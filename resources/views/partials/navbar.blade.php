<div class="marquee-banner">
    <div class="marquee-content">
        <span class="marquee-item">RAW_STREETWEAR_2024 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
        <span class="marquee-item">RAW_STREETWEAR_2024 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
        <span class="marquee-item">RAW_STREETWEAR_2024 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
        <span class="marquee-item">RAW_STREETWEAR_2024 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
    </div>
</div>
<nav class="brutal-nav">
    <div class="container flex-between">
        <div class="flex" style="align-items: center; gap: 20px;">
            <a href="/" class="nav-brand brutal-font" style="text-decoration: none;">VOID_STREET</a>
            <% if (path === '/products' || path === '/cart') { %>
                <div style="background: black; color: var(--neon-green); padding: 4px 10px; font-weight: 900; font-size: 0.7rem; border: 2px solid var(--neon-green); letter-spacing: 1px; box-shadow: 4px 4px 0px var(--neon-green);">
                    [SYSTEM_ACTIVE]
                </div>
            <% } %>
        </div>
        <div class="flex" style="gap: 10px; align-items: center;">
            <a href="/products" class="brutal-font nav-link <%= path === '/products' ? 'active' : '' %>">VAULT</a>
            <div class="nav-separator"></div>
            <a href="/cart" class="brutal-font nav-link <%= path === '/cart' ? 'active' : '' %>" style="display: flex; align-items: center; gap: 8px;">
                YOUR LOOT 
                <span class="cart-badge">2</span>
            </a>
            <div class="nav-separator"></div>
            <a href="/wishlist" class="brutal-font nav-link <%= path === '/wishlist' ? 'active' : '' %>" style="display: flex; align-items: center; gap: 8px;">
                SAVED_VAULT
                <span id="wishlist-badge" class="cart-badge" style="background: var(--accent-pink); color: white; display: none;">0</span>
            </a>
            <div class="nav-separator"></div>
            <a href="/profile" class="brutal-font nav-link <%= path === '/profile' ? 'active' : '' %>">PROFILE</a>
            <div class="nav-separator"></div>
            <a href="/login" class="brutal-font nav-link <%= path === '/login' ? 'active' : '' %>">LOGIN</a>
            <div class="nav-separator"></div>
            <a href="/admin" class="brutal-font nav-link" style="background: black; color: white;">[GO_TO_ADMIN]</a>
        </div>
    </div>
</nav>
