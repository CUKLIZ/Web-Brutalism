<p align="center">
  <img src="https://img.shields.io/badge/TypeScript-5.x-3178C6?style=flat-square&logo=typescript"/>
  <img src="https://img.shields.io/badge/Vite-5.x-646CFF?style=flat-square&logo=vite"/>
  <img src="https://img.shields.io/badge/CSS3-Neo--Brutalist-FF006E?style=flat-square&logo=css3"/>
  <img src="https://img.shields.io/badge/Status-Design_Only-A3FF00?style=flat-square"/>
</p>

# ⚡ VOID_STREET

> **Underground Neo-Brutalist Streetwear E-Commerce Engine**

`VOID_STREET` is a high-contrast, zero-compromise underground digital storefront built as a **pure frontend prototype**. Designed with a raw **Neo-Brutalist** aesthetic — screaming neon accents, oversized typography, heavy black borders, and hard-as-concrete structural grids — engineered for subversive fashion labels and streetwear collectibles.

> ⚠️ **This is the `main` branch** — a fully functional **UI/UX design prototype** running entirely on client-side storage. No backend. No database. Pure visual system.

---

## 🖤 THE DESIGN MANIFESTO

- **Zero Border-Radius** — All structural components locked into rigid rectangular blocks
- **Aggressive Outlines** — Heavy `4px`/`8px` solid black borders separating core compartments
- **Hard Isometric Shadows** — No blurry drop-shadows. Depth via strict flat translations (`box-shadow: 10px 10px 0px 0px #000`)
- **High-Contrast Accents** — Void Black, Subcultural Neon Green, Acid Pink, Industrial Gray
- **Monospace Telemetry Labeling** — Bracketed monospace tags (`[ PROTOCOL_V1 ]`) for immersive terminal UX

---

## 💾 TECH STACK

| Layer | Tech |
|-------|------|
| Frontend | Vanilla TypeScript |
| Styling | Custom CSS (Neo-Brutalist Design System) |
| Build Tool | Vite |
| Storage | Client-Side (localStorage) |
| Auth | Simulated Session (localStorage) |
| Backend | ❌ None — prototype only |
| Database | ❌ None — prototype only |

---

## ⚡ FEATURES

### 🔒 Auth System (Simulated)
- Register & Login via localStorage session simulation
- Role-based UI states: `customer`, `admin`
- Ban system — blacklisted users hit a custom intercept screen with terminal-style UI

### 🧥 Product Catalog
- Responsive brutalist product grid
- Client-side category filter & keyword search
- Hover offset states with CSS transform translations
- Multi-row modular display with sizes, weights, and material specs

### 🔍 Product Detail
- Multi-image gallery (main + secondary images)
- Size selector with per-size stock counter (static data)
- Product specs panel (content, weight, fit, colour)
- Add to cart (simulated auth required)

### 🛒 Cart & Checkout
- Full cart management via localStorage (add, update quantity, remove)
- Free shipping threshold calculation
- Real-time cart count badge in navbar
- Checkout with address input form
- Live price math: subtotal, shipping tariff, tax codes

### ⏱️ Order & Payment Simulation
- Order generated with unique order code (`VX-YYMMDD-XXXXX`)
- 15-minute payment countdown timer
- `SIMULATE_PAYMENT` trigger → status becomes `PAID`
- Manual order expiry → status becomes `EXPIRED`
- Order detail page with full manifest view

### ❤️ Wishlist — SAVED_VAULT
- Save/unsave products (no reload, localStorage)
- Dedicated `/wishlist` page with brutalist collage card layout
- Random card skew rotations (`-1deg` to `1.5deg`) for stencil collage effect
- Wishlist count badge in navbar
- Purge all with confirmation modal
- Quick-loot: migrate wishlist item directly to cart

### ⭐ Review System (Simulated)
- Star rating (1–5) with interactive brutal hover selector
- Text review body input
- Only users with `STATUS: PAID` orders can submit reviews (simulated gate)
- One review per product per simulated user
- Average rating + distribution bar displayed on product page

### 👤 Profile
- Username & email update (persisted in localStorage)
- Password change
- Avatar upload (base64 stored locally)
- Transaction history with order status

### 🛠️ Root Console Dashboard (Admin Prototype)
- Revenue stats display (static/seeded data)
- Product CRUD — create and edit product draft cards (live-renders in UI)
- User list with clearance titles (`ADMIN | VERIFIED | USER`) and ban controls
- Session purge protocols with multi-step confirmation modal

---

## 🧩 PROJECT STRUCTURE

```
VOID_STREET/
├── public/
│   ├── css/
│   │   └── style.css            # System CSS: root variables & animation keys
│   └── js/
│       └── app.js               # Client loop: wishlist state, checkout flow, auth portals
├── resources/
│   └── views/
│       ├── layout.blade.php     # Shell framework (Vite resource pipelines)
│       ├── components/
│       │   └── product-card.blade.php  # Global product tile with wishlist triggers
│       ├── partials/
│       │   ├── navbar.blade.php  # Global navigator: monospaced counters & telemetry badge
│       │   └── footer.blade.php  # Industrial legal notes & subcultural credits
│       └── pages/
│           ├── products.blade.php        # Main apparel catalog grid
│           ├── product-detail.blade.php  # Extreme detail panels & ratings list
│           ├── cart.blade.php            # Loot queue checkout preparation page
│           ├── checkout.blade.php        # Address matrices & invoice details
│           ├── order-success.blade.php   # Ledger invoices & rating form models
│           ├── wishlist.blade.php        # Dynamic SAVED_VAULT visual console
│           ├── profile.blade.php         # Profile credential update matrices
│           ├── login.blade.php           # Session decrypt auth views
│           ├── banned.blade.php          # Account restriction intercept screen
│           └── 404.blade.php             # Broken destination intercept page
├── server.ts                    # Backend compilation gateway & routing handlers
├── tsconfig.json                # Strict TypeScript system settings
└── package.json                 # Application packaging & scripting protocols
```

---

## 🚀 INSTALLATION

### Requirements
- Node.js & NPM

### Steps

```bash
# 1. Clone the main branch
git clone -b main https://github.com/CUKLIZ/Web-Brutalism.git
cd Web-Brutalism

# 2. Install JS dependencies
npm install

# 3. Start dev server
npm run dev
```

App runs at `http://localhost:5173`

---

## 🔄 WORKFLOW

### User Flow
1. Browse catalog freely without login
2. Simulated login required to add to cart, wishlist, or checkout
3. Select size → add to bag
4. Checkout → fill address → place order (simulated)
5. Simulate payment within 15 minutes
6. After order `PAID` → can leave a review (simulated gate)

### Admin Flow
1. Login with admin credentials (seeded in localStorage)
2. Access root console dashboard
3. Manage products and users from sidebar

---

## 🎨 COLOR PALETTE

```
--brutal-black:  #0a0a0a
--neon-green:    #39FF14
--brutal-pink:   #FF1493
--gallery-white: #FFFFFF
--industrial:    #D9D9D9
```

---

## 🗺️ ROADMAP

- [x] Auth system simulation (register, login, ban)
- [x] Role hierarchy UI (customer, admin)
- [x] Product catalog with client-side search & filter
- [x] Cart & checkout flow (localStorage)
- [x] Order management & payment simulation
- [x] Wishlist — SAVED_VAULT
- [x] Review & rating system (simulated gate)
- [x] Admin panel prototype (products, orders, users)
- [x] Custom 404 & banned pages
- [ ] Real backend (Laravel) → see [`development` branch](https://github.com/CUKLIZ/Web-Brutalism/tree/development)
- [ ] Real payment gateway (Midtrans / Xendit)
- [ ] MySQL persistent storage
- [ ] Email notifications
- [ ] Dark mode / infrared inversion toggle
- [ ] Mobile responsive improvements

---

## 📸 SCREENSHOTS

### 🖥️ Catalog
![Catalog](docs/screenshots/catalog.png)

### 👗 Product Detail
![Product Detail](docs/screenshots/product-detail.png)

### 🛒 Cart
![Cart](docs/screenshots/cart.png)

### ❤️ SAVED_VAULT (Wishlist)
![Wishlist](docs/screenshots/wishlist.png)

### ⚙️ Admin Panel
![Admin Panel](docs/screenshots/admin.png)

---

## 🔗 BRANCHES

| Branch | Description |
|--------|-------------|
| `main` | ⚡ Frontend prototype — you are here |
| `development` | ⚔️ Full Laravel + MySQL implementation |

---

## 📄 LICENSE

MIT License — Built for the underground, open for the culture.

---

<div align="center">
  <strong>BUILT FOR THE UNDERGROUND. NO_POLISH_REQUIRED.</strong>
  <br><br>
  <code>VOID_STREET © 2026</code>
</div>
