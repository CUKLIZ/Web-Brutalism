<% layout('layout') %>

<section class="container" style="padding: 60px 0; background: #D9D9D9; min-height: 100vh;">
    <div class="grid" style="grid-template-columns: 1fr 450px; gap: 40px; align-items: start;">
        
        <!-- LEFT SIDE: ASYMMETRICAL IMAGE GRID -->
        <div style="display: flex; flex-direction: column; gap: 40px;">
            <div style="position: relative;">
                <div style="position: absolute; top: -10px; left: -10px; width: 40px; height: 40px; border-top: 4px solid black; border-left: 4px solid black; z-index: 5;"></div>
                <div class="offset-box" style="width: 100%;">
                    <div style="border: 4px solid black; background: #000; position: relative; line-height: 0;">
                        <img src="<%= product.images && product.images[0] ? product.images[0] : product.image %>" alt="<%= product.name %>" style="width: 100%; border: 4px solid black; filter: contrast(110%);">
                        <div style="position: absolute; bottom: 40px; right: 0; background: var(--neon-green); border: 4px solid black; padding: 10px 30px; transform: translateX(20px);">
                            <h2 style="font-size: 3rem; line-height: 1; margin: 0; font-weight: 900;"><%= formatPrice(product.price) %></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 30px;">
                <div style="border: 4px solid black; background: #000; line-height: 0;">
                    <img src="<%= product.images && product.images[1] ? product.images[1] : 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80' %>" style="width: 100%; filter: grayscale(100%) contrast(150%);">
                </div>
                <div style="border: 4px solid black; background: #000; line-height: 0; transform: rotate(2deg);">
                    <img src="<%= product.images && product.images[2] ? product.images[2] : 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&q=80' %>" style="width: 100%; filter: brightness(0.8) contrast(1.2);">
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: DENSE CONTROL PANEL -->
        <div style="position: sticky; top: 120px;">
            <div class="flex" style="gap: 10px; margin-bottom: 20px;">
                <span style="background: black; color: white; padding: 4px 12px; font-weight: 900; font-size: 0.7rem; border: 2px solid black;">LIMITED_EDITION</span>
                <span style="background: var(--neon-green); color: black; padding: 4px 12px; font-weight: 900; font-size: 0.7rem; border: 2px solid black;">NEW_DROP</span>
                <span style="background: var(--accent-pink); color: white; padding: 4px 12px; font-weight: 900; font-size: 0.7rem; border: 2px solid black;">LOW_STOCK</span>
            </div>

            <div style="margin-bottom: 30px;">
                <p class="brutal-font" style="font-size: 0.8rem; margin-bottom: 5px; opacity: 0.6;">CYBER_CORE</p>
                <h1 style="font-size: 3.5rem; line-height: 1; font-weight: 900; letter-spacing: -2px; margin: 0;"><%= product.name.replace(' ', '\n') %></h1>
            </div>

            <!-- SPECIFICATIONS PANEL -->
            <div style="border: 4px solid black; background: white; margin-bottom: 30px; position: relative; box-shadow: 8px 8px 0px black;">
                <div style="position: absolute; top: -15px; right: 20px; background: black; color: white; padding: 2px 10px; font-size: 0.6rem; font-weight: 900; border: 2px solid black;">DATASHEET_V1.0</div>
                <div style="padding: 20px; border-bottom: 2px solid black; display: flex; gap: 20px;">
                    <div style="width: 4px; background: #0000FF;"></div>
                    <p style="font-weight: 900; font-size: 0.9rem; line-height: 1.2; text-transform: uppercase;">
                        HEAVYWEIGHT 500GSM FLEECE. OVERSIZED BOX CUT. REINFORCED STITCHING FOR URBAN DESTRUCTION. GLOW-IN-DARK PRINTED GRAPHICS.
                    </p>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="padding: 10px; border-right: 2px solid black; border-bottom: 2px solid black; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_CONTENT</span><br>100% C-TECH COTTON
                    </div>
                    <div style="padding: 10px; border-bottom: 2px solid black; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_WEIGHT</span><br>1.2KG // HEAVY
                    </div>
                    <div style="padding: 10px; border-right: 2px solid black; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_FIT</span><br>VOID_RELAXED_CUT
                    </div>
                    <div style="padding: 10px; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_COLOUR</span><br>DISTRICT_GR_LII8
                    </div>
                </div>
            </div>

            <!-- SIZE SELECTOR -->
            <div style="margin-bottom: 40px;">
                <div class="flex-between" style="border-bottom: 4px solid black; padding-bottom: 5px; margin-bottom: 15px;">
                    <p style="font-weight: 900; font-style: italic; font-size: 1.2rem;">SELECT_SIZE</p>
                    <a href="#" style="font-size: 0.6rem; color: #888; font-weight: 900;">SIZE_GUIDE.PDF</a>
                </div>
                <div class="flex" style="gap: 10px;">
                    <% ['S', 'M', 'L', 'XL'].forEach(size => { %>
                        <button class="brutal-button" style="width: 50px; height: 50px; padding: 0; font-size: 1rem; display: flex; align-items: center; justify-content: center; background: <%= size === 'M' ? 'black' : 'white' %>; color: <%= size === 'M' ? 'white' : 'black' %>;">
                            <%= size %>
                        </button>
                    <% }) %>
                </div>
            </div>

            <!-- ACTIONS -->
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <button class="brutal-button buy-btn" style="background: var(--neon-green); color: black; font-size: 2.5rem; width: 100%; padding: 25px 0; display: flex; align-items: center; justify-content: space-between; padding-left: 30px; padding-right: 30px;">
                    <span style="font-style: italic;">ADD_TO_BAG</span>
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="square" stroke-linejoin="miter"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </button>
                <button class="brutal-button" style="background: #E5E5E5; color: black; font-size: 1.2rem; width: 100%; padding: 15px 0; font-style: italic;">
                    INSTANT_BUY_CMD
                </button>
            </div>
            
            <p style="margin-top: 30px; font-size: 0.6rem; font-weight: 900; opacity: 0.6; line-height: 1.5;">
                [CRITICAL_WARNING]: ALL TRANSACTIONS ARE FINAL. THE VOID DOES NOT ISSUE REFUNDS. TRACKING DATA WILL BE SENT TO YOUR REGISTERED TERMINAL WITHIN 48H.
            </p>
        </div>

    </div>
</section>
