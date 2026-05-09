<div class="marquee-banner">
    <div class="marquee-content">
        <span class="marquee-item">RAW_STREETWEAR_2026 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
        <span class="marquee-item">RAW_STREETWEAR_2026 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
        <span class="marquee-item">RAW_STREETWEAR_2026 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
        <span class="marquee-item">RAW_STREETWEAR_2026 // FREE SHIPPING FOR THE CULT // NO_POLISH_REQUIRED //</span>
    </div>
</div>
<nav class="brutal-nav">
    <div class="container flex-between">
        <div class="flex" style="align-items: center; gap: 20px;">
            <a href="/" class="nav-brand brutal-font" style="text-decoration: none;">VOID_STREET</a>
            @if(request()->is('products') || request()->is('cart'))
                <div style="background: black; color: var(--neon-green); padding: 4px 10px; font-weight: 900; font-size: 0.7rem; border: 2px solid var(--neon-green); letter-spacing: 1px; box-shadow: 4px 4px 0px var(--neon-green);">
                    [SYSTEM_ACTIVE]
                </div>
            @endif
        </div>
        <div class="flex" style="gap: 10px; align-items: center;">
            <a href="/products" class="brutal-font nav-link {{ request()->is('products') ? 'active' : '' }}">VAULT</a>
            <div class="nav-separator"></div>

            @auth
                <a href="/cart" class="brutal-font nav-link {{ request()->is('cart') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px;">
                    YOUR LOOT
                    <span class="cart-badge">2</span>
                </a>
                <div class="nav-separator"></div>
                <a href="/profile" class="brutal-font nav-link {{ request()->is('profile') ? 'active' : '' }}">PROFILE</a>

                @if(Auth::user()->role === 'admin')
                    <div class="nav-separator"></div>
                    <a href="/admin" class="brutal-font nav-link" style="
                        background: var(--neon-green);
                        color: black;
                        border: 2px solid black;
                        box-shadow: 3px 3px 0px black;
                        padding: 4px 12px;
                        font-size: 0.75rem;
                        letter-spacing: 1px;
                        transition: all 0.1s ease;
                        text-decoration: none;
                    "
                    onmouseover="this.style.boxShadow='1px 1px 0px black'; this.style.transform='translate(2px,2px)'"
                    onmouseout="this.style.boxShadow='3px 3px 0px black'; this.style.transform='translate(0,0)'"
                    >⚡ ADMIN_PANEL</a>
                @endif
            @else
                <a href="/login" class="brutal-font nav-link {{ request()->is('login') ? 'active' : '' }}">LOGIN</a>
                <div class="nav-separator"></div>
            @endauth
        </div>
    </div>
</nav>