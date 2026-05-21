# ⚡ VOID_STREET

```
 ██████╗  ██████╗ ██████╗       ███████╗████████╗██████╗ ███████╗███████╗████████╗
██╔═══██╗██╔═══██╗██╔══██╗      ██╔════℘╚══██╔══℘██╔══██╗██╔════℘██╔════℘╚══██╔══℘
██║   ██║██║   ██║██║  ██║█████╗███████╗   ██║   ██████╔℘█████╗  ███████╗   ██║   
██║   ██║██║   ██║██║  ██║╚════℘╚════██║   ██║   ██╔══██╗██╔══℘  ╚════██║   ██║   
╚██████╔℘╚██████╔℘██████╔℘      ███████║   ██║   ██║  ██║███████╗███████║   ██║   
 ╚═════℘  ╚═════℘ ╚═════℘       ╚══════℘   ╚═℘   ╚═℘  ╚═℘╚══════℘╚══════℘   ╚═℘   
```

> **UNDERGROUND NEO-BRUTALIST STREETWEAR E-COMMERCE ENGINE**
> 
> *An architectural, high-contrast, zero-compromise storefront designed for the digital avant-garde.*

---

## 🖤 THE BRAND MANIFESTO

Traditional Web 2.0 designs are soft, silent, and compliant. They hide under smooth shadows, rounded corners, and polite pastel color palettes. **VOID_STREET** breaks the status quo. 

Born from the intersection of underground cypherpunk culture, industrial architecture, and raw desktop terminals, VOID_STREET implements an uncompromised **Neo-Brutalist** visual system. It strips away all modern styling layers to expose the raw digital concrete beneath. Solid borders, aggressive alignments, stark typography, and screaming vivid colors construct a high-intensity stage for contemporary streetwear collectibles.

---

## 🎨 VISUAL IDENTITY SYSTEM

At VOID_STREET, the technical raw materials *are* the decoration. Every visual choice is intentional, sharp, and highly readable:

| Spec / Element | Styling Instruction | Semantic Meaning |
| :--- | :--- | :--- |
| **Borders** | `border: 4px solid #000000;` (Zero borderRadius) | Structural isolation, uncompromising rigidity |
| **Shadows (Offset)**| `box-shadow: 10px 10px 0px 0px #000000;` (No blur) | Hard flat isometric depth representation |
| **Primary Base** | `#FFFFFF` paired with `#D9D9D9` (Industrial Gray) | Monochromatic architectural concrete canvas |
| **Accent Glow** | `#39FF14` (Subcultural Neon Green) | Operational active terminal state |
| **Alert Flag** | `#FF0000` (Signal Stop Warning Red) | Security restriction, expired checkout sequences |
| **Brutal Pink** | `#FF1493` (Acid Pink Accent) | Saved items indicator, vault registry additions |

---

## ⚡ CORE MODULES & ARCHITECTURE

The VOID_STREET system is comprised of fully operational modular frameworks, integrated purely in client-side storage to enable immediate persistent operations:

### 1. 📂 Core Storefront & Catalog Feed
*   **Grid Collapse Architecture**: Responsive grid containers displaying raw item modules with thick dividing walls.
*   **Hover Offset States**: Cards and details spring dynamically against pointer triggers utilizing CSS transform translations (`translate(-4px, -4px)`).
*   **System Detail Showcase**: Multi-row, modular display details for sizes, weights, serial numbers, and material structures.

### 2. 💖 The Saved Vault (Wishlist System)
*   **Haptic Heart Interceptors (`❤`)**: Clickable dual-state heart triggers nested on catalog containers and inside detailed views.
*   **Collage Rotations**: Item cards display random skew rotations (`-1deg` to `1.5deg`) to mimic a physical underground stencil collage.
*   **Interactive Cart Migration**: Quick-loot triggers allow users to instantaneously pull items from their wishlist directly into the live checkout bag.

### 3. 🛒 Loot Registries & Checkout
*   **Live Math Processing**: Instant, dynamic local calculations tracking price aggregates, shipping tariffs, and luxury tax codes.
*   **The 15-Minute Reservation Guard**: Tracing state countdown clocks that reserve products. Failed transactions flag orders as `EXPIRED` immediately.
*   **Interactive payment simulator**: A built-in terminal block enabling instant order completions and ledger synchronization.

### 4. ⭐ Verified Community Feedback (Review System)
*   **Strict Access Control**: Only verified purchasers containing confirmed, completed transactions (`STATUS: PAID`) can write feedback records.
*   **Star rating grids**: Large interactive brutal hover blocks representing mathematical review distributions (1–5 scale).
*   **Telemetry metadata**: Stamped timestamps and user authorization credentials verify review authenticity.

### 5. ⚙️ Root Console Dashboard
*   **Modular Inventory Interface**: Real-time product creation and edit fields that live-render product draft cards.
*   **Security Access Register (User list)**: Total user records, activity logs, clearance titles (`ADMIN | VERIFIED | USER`), and banning pipelines.
*   **Session Purge Protocols**: Clear local state configurations with explicit multi-step verification prompts (`window.BrutalModal.confirm`).

---

## 📂 DIRECTORY WALKTHROUGH

The system is constructed with a highly organized modular layout:

```bash
VOID_STREET/
├── public/
│   ├── css/
│   │   └── style.css            # System CSS: Root custom variables & animation keys
│   └── js/
│       └── app.js               # Client Loop: Wishlist state, checkout flow, auth portals
├── resources/
│   └── views/
│       ├── layout.blade.php     # Shell Framework (Vite resource pipelines)
│       ├── components/
│       │   └── product-card.blade.php # Global product tile with integrated Wishlist triggers
│       ├── partials/
│       │   ├── navbar.blade.php  # Global Navigator: Monospaced stock counters & telemetry badge
│       │   └── footer.blade.php  # Industrial legal notes & subcultural credits
│       └── pages/
│           ├── products.blade.php       # The Main Apparel Catalog Grid
│           ├── product-detail.blade.php  # Extreme detail panels & ratings list
│           ├── cart.blade.php           # Loot queue checkout preparation page
│           ├── checkout.blade.php       # Address matrices & secure invoice details
│           ├── order-success.blade.php  # Ledger invoices & rating form models
│           ├── wishlist.blade.php       # Dynamic Saved Vault visual console
│           ├── profile.blade.php        # Profile credential update matrices
│           ├── login.blade.php          # Session decrypt auth views
│           ├── banned.blade.php         # Brutal account restriction screen
│           └── 404.blade.php            # Broken destination intercept page
├── server.ts                    # Backend compilation gateway & routing handlers
├── tsconfig.json                # Strict TypeScript system settings
└── package.json                 # Application packaging details & scripting protocols
```

---

## 🛠️ RUNNING THE ARCHIVES LOCALLY

Bring the system online on your local architecture:

### 1. Replicate Project Environment
```bash
git clone https://github.com/your-username/void-street.git
cd void-street
```

### 2. Fetch Dependency Tree
Deploy PHP Composer framework definitions:
```bash
composer install
```

### 3. Generate Encryption Signatures
Clone environment configuration files and initialize cryptographically secure keys:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Wake Up Dev Server
Bring the web server operational on your terminal network:
```bash
php artisan serve
```
Open up your browser tab to `http://localhost:8000` to interact with the catalog.

---

## 🗺️ SYSTEM DEPLOYMENT ROADMAP

- [ ] **Midtrans API Integrations**: Secure digital credit routing pipelines.
- [ ] **SQL Database Handlers (Postgres/MySQL)**: Persistent storage records replacing local states.
- [ ] **Multi-Tier Product Variants**: Advanced options matching size matrices, limited editions, and serial drops.
- [ ] **SMTP Outbox Warning Logs**: Instant notification text dispatches upon order completions.
- [ ] **Aesthetic Inversion Toggle**: High-contrast, inverted themes simulating infrared camera feedback.

---

```
[ STATUS: SYSTEM ONLINE ]
[ SECURITY LEVEL: SECURE ]
[ ENGINE VERSION: V2.1.0-BRUTAL ]
```

<div align="center">
  <h3>⚡ BUILT FOR THE UNDERGROUND ⚡</h3>
</div>
