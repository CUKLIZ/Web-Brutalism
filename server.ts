import express from "express";
import path from "path";
import { fileURLToPath } from "url";
import engine from "ejs-mate";
import { getProducts, getProductById, seedProducts } from "./services/db.js";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

async function startServer() {
  const app = express();
  const PORT = 3000;

  // Use ejs-mate for layout support
  app.engine("blade.php", engine);
  app.set("view engine", "blade.php");
  app.set("views", path.join(__dirname, "resources/views"));

  app.use(express.static(path.join(__dirname, "public")));

  app.use((req, res, next) => {
    res.locals.path = req.path;
    res.locals.asset = (file: string) => `/${file.startsWith('/') ? file.slice(1) : file}`;
    res.locals.formatPrice = (price: number | string) => {
      const numPrice = typeof price === 'string' ? parseFloat(price) : price;
      return 'Rp ' + numPrice.toLocaleString('id-ID');
    };
    next();
  });

  // Seed data if empty (simplified check)
  const existingProducts = await getProducts();
  if (existingProducts.length === 0) {
    await seedProducts();
  }

  app.get("/", async (req, res) => {
    const products = await getProducts();
    res.render("pages/home", { products });
  });

  app.get("/products", async (req, res) => {
    const { q, category } = req.query;
    const allProducts = await getProducts();
    
    const categories = ["ALL", ...new Set(allProducts.map((p: any) => p.category))];
    
    res.render("pages/products", { 
      products: allProducts, 
      categories,
      activeCategory: category || "ALL",
      searchQuery: q || ""
    });
  });

  app.get("/product/:id", async (req, res) => {
    const product = await getProductById(req.params.id);
    res.render("pages/product-detail", { product });
  });

  app.get("/cart", async (req, res) => {
    const products = await getProducts();
    res.render("pages/cart", { cartItems: [products[0], products[1]].filter(Boolean) });
  });

  app.get("/login", (req, res) => {
    res.render("pages/login");
  });

  app.get("/register", (req, res) => {
    res.render("pages/register");
  });

  // Admin Routes
  app.get("/admin", async (req, res) => {
    const products = await getProducts();
    res.render("admin/dashboard", { path: '/admin', products });
  });

  app.get("/admin/products", async (req, res) => {
    const products = await getProducts();
    // Transform stock for admin view if needed
    const adminProducts = products.map((p: any) => ({
      ...p,
      stockStr: p.stock ? Object.entries(p.stock).map(([s, q]) => `${s}:${q}`).join(' ') : 'N/A'
    }));
    res.render("admin/products", { path: '/admin/products', products: adminProducts });
  });

  app.get("/admin/add-product", (req, res) => {
    res.render("admin/add_product", { path: '/admin/products' });
  });

  app.get("/admin/edit-product/:id", (req, res) => {
    // Single dummy product for edit view
    const product = { 
      id: req.params.id, 
      name: "VOID_CARGO", 
      price: 2475000, 
      category: "PANTS", 
      stock: { s: 5, m: 12, l: 8, xl: 2 } 
    };
    res.render("admin/edit_product", { path: '/admin/products', product });
  });

  app.get("/checkout", (req, res) => {
    res.render("pages/checkout");
  });

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`Server running on http://localhost:${PORT}`);
  });
}

startServer();
