import express from "express";
import path from "path";
import { fileURLToPath } from "url";
import engine from "ejs-mate";

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
  app.use(express.json());
  app.use(express.urlencoded({ extended: true }));

  app.use((req, res, next) => {
    res.locals.path = req.path;
    res.locals.asset = (file: string) => `/${file.startsWith('/') ? file.slice(1) : file}`;
    res.locals.formatPrice = (price: number | string) => {
      const numPrice = typeof price === 'string' ? parseFloat(price) : price;
      return 'Rp ' + numPrice.toLocaleString('id-ID');
    };
    next();
  });

  // Sample data with categories
  const products = [
    { id: 1, name: "BRUTAL TEE", price: 675000, category: "T-SHIRT", image: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80" },
    { id: 2, name: "VOID CAPSULE", price: 1800000, category: "ACCESSORIES", image: "https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400&q=80" },
    { id: 3, name: "LOOT BAG", price: 1275000, category: "ACCESSORIES", image: "https://images.unsplash.com/photo-1544816153-12ad5d714b21?w=400&q=80" },
    { id: 4, name: "RAW DENIM", price: 2850000, category: "PANTS", image: "https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&q=80" },
    { id: 5, name: "VOID HOODIE", price: 1425000, category: "T-SHIRT", image: "https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80" },
    { id: 6, name: "TECH JACKET", price: 3150000, category: "OUTERWEAR", image: "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&q=80" },
  ];

  const categories = ["ALL", ...new Set(products.map(p => p.category))];

  // In-memory "database" for orders
  let orders: any[] = [];

  app.get("/", (req, res) => {
    res.render("pages/home", { products });
  });

  app.get("/products", (req, res) => {
    const { q, category } = req.query;
    
    res.render("pages/products", { 
      products: products, 
      categories,
      activeCategory: category || "ALL",
      searchQuery: q || ""
    });
  });

  app.get("/product/:id", (req, res) => {
    const product = products.find(p => p.id === parseInt(req.params.id));
    res.render("pages/product-detail", { product });
  });

  app.get("/cart", (req, res) => {
    res.render("pages/cart", { cartItems: [products[0], products[1]] });
  });

  app.get("/login", (req, res) => {
    res.render("pages/login");
  });

  app.get("/register", (req, res) => {
    res.render("pages/register");
  });

  // Admin Routes (Dummy Data Only)
  app.get("/admin", (req, res) => {
    res.render("admin/dashboard", { path: '/admin', products });
  });

  app.get("/admin/products", (req, res) => {
    const adminProducts = [
      { id: 101, name: "VOID_CARGO", price: 2475000, category: "PANTS", stock: "S:5 M:12 L:8" },
      { id: 102, name: "SIGNATURE_TEE", price: 825000, category: "T-SHIRT", stock: "S:20 M:0 L:15" },
      { id: 103, name: "HACKER_HOODIE", price: 1425000, category: "OUTERWEAR", stock: "S:8 M:8 L:8" },
      { id: 104, name: "DATA_CAP", price: 525000, category: "ACCESSORIES", stock: "OS:45" },
      { id: 105, name: "VOID_RUNNER_V1", price: 3150000, category: "SHOES", stock: "40:2 41:5 42:3" },
      { id: 106, name: "NEON_BEANIE", price: 675000, category: "ACCESSORIES", stock: "OS:12" },
    ];
    res.render("admin/products", { path: '/admin/products', products: adminProducts });
  });

  app.get("/admin/users", (req, res) => {
    const adminUsers = [
      { id: 1, username: "VOID_KEEPER", email: "keeper@void.st", role: "ADMIN", status: "ACTIVE", joined: "2024-01-12", orders: 42, lastActive: "2MIN AGO" },
      { id: 2, username: "STREET_GHOST", email: "ghost@neon.city", role: "USER", status: "ACTIVE", joined: "2024-03-05", orders: 12, lastActive: "5H AGO" },
      { id: 3, username: "RAW_ARCHIVE", email: "raw@vintage.io", role: "USER", status: "BANNED", joined: "2023-11-20", orders: 2, lastActive: "128D AGO" },
      { id: 4, username: "CYBER_NOMAD", email: "nomad@mesh.net", role: "VERIFIED", status: "ACTIVE", joined: "2024-04-01", orders: 25, lastActive: "NOW" },
      { id: 5, username: "NULL_POINTER", email: "null@void.st", role: "USER", status: "VERIFIED", joined: "2024-02-14", orders: 8, lastActive: "1D AGO" },
      { id: 6, username: "DATA_DRIP", email: "drip@loot.vault", role: "USER", status: "ACTIVE", joined: "2024-05-10", orders: 0, lastActive: "3M AGO" },
    ];
    res.render("admin/users", { path: '/admin/users', users: adminUsers });
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

  app.get("/order-success", (req, res) => {
    res.render("pages/order-success");
  });

  app.get("/order-success.html", (req, res) => {
    res.render("pages/order-success");
  });

  app.get("/profile", (req, res) => {
    res.render("pages/profile");
  });

  app.get("/banned", (req, res) => {
    res.render("pages/banned");
  });

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`Server running on http://localhost:${PORT}`);
  });
}

startServer();
