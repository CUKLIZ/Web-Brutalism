import express from "express";
import path from "path";
import { fileURLToPath } from "url";
import engine from "ejs-mate";
import knex from "knex";
import config from "./knexfile.js";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const db = knex(config);

async function startServer() {
  const app = express();
  const PORT = 3000;

  // Use ejs-mate for layout support
  app.engine("blade.php", engine);
  app.set("view engine", "blade.php");
  app.set("views", path.join(__dirname, "resources/views"));

  app.use(express.static(path.join(__dirname, "public")));
  app.use(express.json());

  app.use((req, res, next) => {
    res.locals.path = req.path;
    res.locals.asset = (file: string) => `/${file.startsWith('/') ? file.slice(1) : file}`;
    res.locals.formatPrice = (price: number | string) => {
      const numPrice = typeof price === 'string' ? parseFloat(price) : price;
      return 'Rp ' + (numPrice || 0).toLocaleString('id-ID');
    };
    next();
  });

  // Helper to get products with their first image
  const getProductsWithImages = async (query?: any) => {
    let q = db('products')
      .leftJoin('product_images', 'products.id', 'product_images.product_id')
      .select('products.*', db.raw('MIN(product_images.image_path) as image'))
      .groupBy('products.id');

    if (query?.category && query.category !== 'ALL') {
      q = q.where('category', query.category);
    }

    if (query?.q) {
      q = q.where('name', 'like', `%${query.q}%`);
    }

    return await q;
  };

  app.get("/", async (req, res) => {
    try {
      const products = await getProductsWithImages();
      res.render("pages/home", { products });
    } catch (error) {
      console.error(error);
      res.status(500).send("Database Error");
    }
  });

  app.get("/products", async (req, res) => {
    try {
      const { q, category } = req.query;
      const products = await getProductsWithImages({ q, category });
      const rawCategories = await db('products').distinct('category').pluck('category');
      const categories = ["ALL", ...rawCategories];
      
      res.render("pages/products", { 
        products, 
        categories,
        activeCategory: (category as string) || "ALL",
        searchQuery: (q as string) || ""
      });
    } catch (error) {
      console.error(error);
      res.status(500).send("Database Error");
    }
  });

  app.get("/product/:id", async (req, res) => {
    try {
      const product = await db('products').where('id', req.params.id).first();
      if (!product) return res.status(404).send("Product Not Found");
      
      const images = await db('product_images').where('product_id', product.id).pluck('image_path');
      const stockResults = await db('product_size_stock')
        .join('sizes', 'product_size_stock.size_id', 'sizes.id')
        .where('product_id', product.id)
        .select('sizes.name', 'product_size_stock.stock');
      
      const stock: any = {};
      stockResults.forEach(s => stock[s.name.toLowerCase()] = s.stock);

      res.render("pages/product-detail", { 
        product: { ...product, image: images[0], images, stock } 
      });
    } catch (error) {
      console.error(error);
      res.status(500).send("Database Error");
    }
  });

  app.get("/cart", async (req, res) => {
    // Still dummy for now as no session/auth logic requested yet
    const products = await getProductsWithImages();
    res.render("pages/cart", { cartItems: products.slice(0, 2) });
  });

  app.get("/login", (req, res) => {
    res.render("pages/login");
  });

  app.get("/register", (req, res) => {
    res.render("pages/register");
  });

  // Admin Routes
  app.get("/admin", async (req, res) => {
    try {
      const products = await getProductsWithImages();
      res.render("admin/dashboard", { path: '/admin', products });
    } catch (error) {
      console.error(error);
      res.status(500).send("Database Error");
    }
  });

  app.get("/admin/products", async (req, res) => {
    try {
      const dbProducts = await db('products').select('*');
      const products = await Promise.all(dbProducts.map(async (p) => {
        const images = await db('product_images').where('product_id', p.id).pluck('image_path');
        const stockResults = await db('product_size_stock')
          .join('sizes', 'product_size_stock.size_id', 'sizes.id')
          .where('product_id', p.id)
          .select('sizes.name', 'product_size_stock.stock');
        
        const stockStr = stockResults.map(s => `${s.name}:${s.stock}`).join(' ');
        return { ...p, image: images[0], stock: stockStr };
      }));
      
      res.render("admin/products", { path: '/admin/products', products });
    } catch (error) {
      console.error(error);
      res.status(500).send("Database Error");
    }
  });

  app.get("/admin/add-product", (req, res) => {
    res.render("admin/add_product", { path: '/admin/products' });
  });

  app.get("/admin/edit-product/:id", async (req, res) => {
    try {
      const product = await db('products').where('id', req.params.id).first();
      if (!product) return res.status(404).send("Not Found");

      const stockResults = await db('product_size_stock')
        .join('sizes', 'product_size_stock.size_id', 'sizes.id')
        .where('product_id', product.id)
        .select('sizes.name', 'product_size_stock.stock');
      
      const stock: any = {};
      stockResults.forEach(s => stock[s.name.toLowerCase()] = s.stock);

      res.render("admin/edit_product", { path: '/admin/products', product: { ...product, stock } });
    } catch (error) {
      console.error(error);
      res.status(500).send("Database Error");
    }
  });


  app.get("/checkout", (req, res) => {
    res.render("pages/checkout");
  });

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`Server running on http://localhost:${PORT}`);
  });
}

startServer();
