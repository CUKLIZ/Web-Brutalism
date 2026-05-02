<% layout('layout') %>

<section class="container" style="padding: 60px 0; background: #D9D9D9; min-height: 100vh;">
    <div style="margin-bottom: 60px;">
        <h1 style="font-size: 8rem; line-height: 0.8; font-style: italic; font-weight: 900; letter-spacing: -4px;">YOUR_LOOT</h1>
        <p class="brutal-font" style="font-size: 2rem; border-bottom: 6px solid black; display: inline-block; padding-bottom: 10px;">[0<%= cartItems.length %>_ITEMS_IN_STORAGE]</p>
    </div>
    
    <% if (cartItems.length === 0) { %>
        <div style="position: relative; overflow: hidden; background: white; border: 8px solid black; padding: 120px 40px; text-align: center; box-shadow: 20px 20px 0px black;">
            <div class="layered-block" style="top: -20px; left: -20px; width: 100px; height: 100px; background: var(--accent-yellow); transform: rotate(-15deg); z-index: 0;"></div>
            <div class="layered-block" style="bottom: -10px; right: 50px; width: 150px; height: 60px; background: var(--neon-green); transform: rotate(5deg); z-index: 0;"></div>
            
            <div style="position: relative; z-index: 1;">
                <h2 style="font-size: clamp(3rem, 10vw, 6rem); line-height: 0.8; margin-bottom: 20px; font-weight: 900; letter-spacing: -3px;">YOUR_LOOT_IS_EMPTY</h2>
                <p class="brutal-font" style="font-size: 1.5rem; margin-bottom: 60px; background: black; color: white; display: inline-block; padding: 5px 15px;">[00_ITEMS_DETECTED_IN_STORAGE]</p>
                <br>
                <a href="/products" class="brutal-button" style="font-size: 2.5rem; background: var(--neon-green); padding: 20px 40px; text-decoration: none;">RETURN_TO_VAULT</a>
            </div>
        </div>
    <% } else { %>
        <div class="cart-grid">
            <!-- List of Items -->
            <div>
                <% cartItems.forEach(item => { %>
                    <% const rotation = (Math.random() * 10 - 5).toFixed(1); %>
                    <div class="cart-item-card" style="transform: rotate(<%= rotation %>deg) <%= cartItems.indexOf(item) % 2 === 1 ? 'translate(4px, 4px)' : '' %>;">
                        <img src="<%= item.image %>" alt="<%= item.name %>" class="cart-item-img" style="border: 8px solid black;">
                        <div style="padding: 20px;">
                            <span class="badge" style="background: #0000AA; color: white;">RARE_LOCKED</span>
                            <h3 style="font-size: 2.2rem; margin-top: 15px; line-height: 1;"><%= item.name.replace(' ', '_') %></h3>
                            <p class="brutal-font" style="font-size: 0.9rem; color: #333; margin-top: 5px;">"ARCHIVE_PIECE"</p>
                            <p class="brutal-font" style="font-size: 0.9rem; margin-top: 15px;">STDS / C_VOID_BLACK</p>
                            <h3 style="font-size: 2.2rem; margin-top: 15px; color: #000;"><%= formatPrice(item.price) %></h3>
                        </div>
                        <div style="padding: 15px; border-left: var(--border-width) solid var(--brutal-black);">
                            <p class="brutal-font" style="font-size: 0.7rem; margin-bottom: 5px;">QTY</p>
                            <div class="qty-box">
                                <button class="qty-btn">-</button>
                                <input type="text" class="qty-input" value="1">
                                <button class="qty-btn">+</button>
                            </div>
                            <button style="width: 100%; border: var(--border-width) solid var(--brutal-black); background: black; color: white; padding: 5px; font-weight: 900; font-size: 0.6rem; margin-top: 10px; cursor: pointer;">REMOVE X</button>
                        </div>
                        <div style="position: absolute; right: 10px; bottom: 10px; font-size: 1.5rem; font-weight: 900; pointer-events: none; opacity: 0.1;">#<%= item.id %></div>
                    </div>
                <% }) %>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div class="flex-between" style="margin-bottom: 15px;">
                        <span class="brutal-font" style="font-size: 0.9rem;">FUELING_PROGRESS</span>
                        <span class="brutal-font" style="font-size: 0.9rem; color: #0000FF;"><%= formatPrice(cartItems.reduce((acc, curr) => acc + curr.price, 0)) %> / Rp 5.000.000 FOR FREE SHIP</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <%= Math.min(100, (cartItems.reduce((acc, curr) => acc + curr.price, 0) / 5000000) * 100) %>%">
                            <%= Math.round(Math.min(100, (cartItems.reduce((acc, curr) => acc + curr.price, 0) / 5000000) * 100)) %>%_SYNCED
                        </div>
                    </div>
                    <p style="font-size: 0.6rem; font-weight: 900; margin-top: 10px;">DROP ANOTHER <%= formatPrice(5000000 - cartItems.reduce((acc, curr) => acc + curr.price, 0)) %> TO UNLOCK GLOBAL TRANSPORT AT ZERO COST.</p>
                </div>
            </div>

            <!-- Summary Panel -->
            <div class="summary-panel">
                <button class="brutal-button" style="width: 100%; text-align: center; background: var(--neon-green); color: black; font-size: 1.4rem; padding: 10px 0; margin-bottom: 40px; border-width: 4px;">
                    APPLY_DISCOUNT
                </button>
                <h2 style="font-size: 3rem; font-style: italic; border-bottom: 6px solid black; padding-bottom: 10px; margin-bottom: 30px;">ORDER_TOTAL</h2>
                
                <div class="flex-between" style="margin-bottom: 15px;">
                    <span class="brutal-font">SUBTOTAL</span>
                    <span class="brutal-font"><%= formatPrice(cartItems.reduce((acc, curr) => acc + curr.price, 0)) %></span>
                </div>
                <div class="flex-between" style="margin-bottom: 15px;">
                    <span class="brutal-font" style="color: #0000FF;">SHIPPING</span>
                    <span class="brutal-font">Rp 15.000 <span style="text-decoration: line-through; margin-left: 10px; color: #0000FF;">Rp 0</span></span>
                </div>

                <div style="border-top: 6px solid black; margin: 30px 0; padding-top: 20px;">
                    <div class="flex-between">
                        <h2 style="font-size: 3rem;">TOTAL</h2>
                        <h2 style="font-size: 3rem;"><%= formatPrice(cartItems.reduce((acc, curr) => acc + curr.price, 0) + 15000) %></h2>
                    </div>
                </div>

                <a href="/checkout" class="brutal-button" style="width: 100%; text-align: center; background: black; color: var(--neon-green); font-size: 2.2rem; padding: 20px 0; margin-bottom: 20px; font-style: italic;">
                    CHECKOUT_NOW
                </a>

                <div class="flex" style="gap: 10px; justify-content: center;">
                    <div class="payment-badge">APPLE_PAY</div>
                    <div class="payment-badge">CRYPTO_OK</div>
                    <div class="payment-badge">CREDIT_X</div>
                </div>

                <div style="margin-top: 60px; background: #ccc; border: var(--border-width) solid var(--brutal-black); padding: 15px;">
                    <p class="brutal-font" style="font-size: 0.9rem; margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                       <span style="background: #0000FF; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;">!</span> 
                       BRUTAL_RULES
                    </p>
                    <div style="font-size: 0.7rem; font-weight: 900; line-height: 2;">
                        _NO REFUNDS<br>
                        _NO EXCHANGES<br>
                        _ALL SALES FINAL<br>
                        _WEAR IT OR REGRET IT
                    </div>
                </div>
            </div>
        </div>
    <% } %>
</section>
