<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN_CONTROL_PANEL // VOID_STREET</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .admin-sidebar {
            width: 260px;
            background: #000;
            color: #fff;
            min-height: 100vh;
            border-right: 6px solid var(--neon-green);
            padding: 30px 20px;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .admin-nav-link {
            display: block;
            padding: 12px 15px;
            color: #fff;
            text-decoration: none;
            font-weight: 900;
            border: 3px solid #333;
            background: #0a0a0a;
            text-transform: uppercase;
            margin-bottom: 10px;
            transition: all 0.1s;
            position: relative;
            font-size: 0.85rem;
        }
        .admin-nav-link:hover {
            border-color: var(--neon-green);
            background: #111;
            transform: translate(-3px, -3px);
            box-shadow: 4px 4px 0px var(--neon-green);
        }
        .admin-nav-link.active {
            background: var(--neon-green);
            color: #000;
            border-color: #000;
            box-shadow: 4px 4px 0px var(--brutal-black);
            transform: translate(-4px, -4px);
        }
        .admin-nav-link.active::before {
            content: '>';
            margin-right: 8px;
        }
        .sidebar-label {
            font-size: 0.55rem;
            font-weight: 900;
            color: #555;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            display: block;
        }
        .admin-main {
            flex: 1;
            padding: 50px;
            background: #D9D9D9;
            min-height: 100vh;
            border-left: 4px solid #000;
        }
        .admin-stat-card {
            background: #fff;
            border: 4px solid #000;
            padding: 25px;
            box-shadow: 10px 10px 0px #000;
            position: relative;
            overflow: hidden;
        }
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            display: flex;
            align-items: flex-start;
        }
    </style>
</head>
<body style="background: #000;">
    <div class="admin-container">
        <div class="admin-sidebar">
            <div>
                <div style="background: var(--neon-green); color: #000; display: inline-block; padding: 1px 6px; font-weight: 900; font-size: 0.6rem; margin-bottom: 8px;">[ADMIN_PORTAL]</div>
                <h2 style="font-size: 1.8rem; color: #fff; line-height: 0.9; margin: 0; font-weight: 900;">SYSTEM_<br>CONTROL</h2>
                <div style="margin-top: 10px; font-size: 0.55rem; font-weight: 900; color: var(--neon-green);">SYS_MODE: ACTIVE // NODE_77</div>
            </div>

            <nav>
                <span class="sidebar-label">PRIMARY_MODULES</span>
                <a href="/admin" class="admin-nav-link <%= path === '/admin' ? 'active' : '' %>">DASHBOARD</a>
                <a href="/admin/products" class="admin-nav-link <%= path === '/admin/products' ? 'active' : '' %>">PRODUCTS_DB</a>
                
                <span class="sidebar-label" style="margin-top: 30px;">OPERATIONS</span>
                <a href="/admin/add-product" class="admin-nav-link">ADD_NEW_ITEM</a>
                
                <div style="margin-top: 80px; border-top: 3px solid #333; padding-top: 30px;">
                    <a href="/" class="admin-nav-link" style="border-color: var(--accent-pink); color: var(--accent-pink);">EXIT_TO_VAULT</a>
                </div>
            </nav>

            <div style="margin-top: auto;">
                <div style="font-size: 0.5rem; font-weight: 900; color: #444; line-height: 2;">
                    UPTIME: 99.98%<br>
                    LATENCY: 12MS<br>
                    ENCRYPTION: AES_256
                </div>
            </div>
        </div>
        <main class="admin-main">
            <%- body %>
        </main>
    </div>
</body>
</html>
