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

                {{-- PROFILE CARD --}}
                <a href="/profile" style="display: flex; align-items: center; gap: 0; border: 3px solid #000; box-shadow: 3px 3px 0px #000; text-decoration: none; background: #fff; transition: all 0.1s ease;"
                   onmouseover="this.style.boxShadow='1px 1px 0px #000'; this.style.transform='translate(2px,2px)'"
                   onmouseout="this.style.boxShadow='3px 3px 0px #000'; this.style.transform='translate(0,0)'">

                    {{-- Avatar --}}
                    <div style="width: 38px; height: 38px; overflow: hidden; border-right: 3px solid #000; flex-shrink: 0;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                 style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--neon-green); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 16px; color: #000;">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div style="padding: 0 10px; display: flex; flex-direction: column; gap: 1px;">
                        <span style="font-weight: 900; font-size: 11px; color: #000; letter-spacing: 1px; line-height: 1;">{{ strtoupper(Auth::user()->username) }}</span>
                        <span style="font-size: 9px; font-weight: 900; color: #888; letter-spacing: 0.5px;">[{{ strtoupper(Auth::user()->role) }}]</span>
                    </div>

                    {{-- Arrow --}}
                    <div style="padding: 0 8px; border-left: 3px solid #000; height: 38px; display: flex; align-items: center;">
                        <span style="font-size: 10px; font-weight: 900; color: #000;">▼</span>
                    </div>
                </a>

                @if(Auth::user()->role === 'admin')
                    <div class="nav-separator"></div>
                    <a href="/admin" class="brutal-font" style="
                        background: black;
                        color: var(--neon-green);
                        border: 3px solid var(--neon-green);
                        box-shadow: 4px 4px 0px var(--neon-green);
                        padding: 6px 14px;
                        font-size: 0.75rem;
                        letter-spacing: 2px;
                        text-decoration: none;
                        display: inline-flex;
                        align-items: center;
                        gap: 6px;
                        transition: all 0.1s ease;
                    "
                    onmouseover="this.style.boxShadow='1px 1px 0px var(--neon-green)'; this.style.transform='translate(3px,3px)'"
                    onmouseout="this.style.boxShadow='4px 4px 0px var(--neon-green)'; this.style.transform='translate(0,0)'"
                    ><span style="font-size: 0.9rem;">⚡</span>[GO_TO_ADMIN]</a>
                @endif
            @else
                <a href="/login" class="brutal-font nav-link {{ request()->is('login') ? 'active' : '' }}">LOGIN</a>
                <div class="nav-separator"></div>
            @endauth
        </div>
    </div>
</nav>