<% layout('layout') %>

<section class="container" style="padding: 60px 0; background: #D9D9D9; min-height: 100vh;">
    <div class="grid" style="grid-template-columns: 1fr 450px; gap: 40px; align-items: start;">
        
        <!-- LEFT SIDE: ASYMMETRICAL IMAGE GRID -->
        <div style="display: flex; flex-direction: column; gap: 40px;">
            <div style="position: relative;">
                <div style="position: absolute; top: -10px; left: -10px; width: 40px; height: 40px; border-top: 4px solid black; border-left: 4px solid black; z-index: 5;"></div>
                <div class="offset-box" style="width: 100%;">
                    <div style="border: 4px solid black; background: #000; position: relative; line-height: 0;">
                        <img src="<%= product.image %>" alt="<%= product.name %>" style="width: 100%; border: 4px solid black; filter: contrast(110%);">
                        <div style="position: absolute; bottom: 40px; right: 0; background: var(--neon-green); border: 4px solid black; padding: 10px 30px; transform: translateX(20px);">
                            <h2 style="font-size: 3rem; line-height: 1; margin: 0; font-weight: 900;"><%= formatPrice(product.price) %></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 30px;">
                <div style="border: 4px solid black; background: #000; line-height: 0;">
                    <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80" style="width: 100%; filter: grayscale(100%) contrast(150%);">
                </div>
                <div style="border: 4px solid black; background: #000; line-height: 0; transform: rotate(2deg);">
                    <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&q=80" style="width: 100%; filter: brightness(0.8) contrast(1.2);">
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
                    <% ['S', 'M', 'L', 'XL', 'XXL'].forEach(size => { %>
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

<!-- REVIEWS SECTION -->
<section class="container" style="padding: 100px 20px; background: #eee; border-top: 8px solid black;">
    <div style="margin-bottom: 60px;">
        <div style="background: black; color: white; display: inline-block; padding: 2px 12px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ COMMUNITY_FEEDBACK ]</div>
        <h2 style="font-size: 4rem; font-weight: 900; line-height: 0.8; letter-spacing: -3px; margin: 0; text-transform: uppercase;">REVIEWS_AND_LOGS</h2>
    </div>

    <div class="grid" style="grid-template-columns: 350px 1fr; gap: 60px; align-items: start;">
        <!-- STATS COLUMN -->
        <div style="position: sticky; top: 120px;">
            <div class="brutal-card" style="background: white; padding: 30px; margin-bottom: 30px; border: 4px solid black; box-shadow: 10px 10px 0px black;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <div id="avg-rating" style="font-size: 5.5rem; font-weight: 900; line-height: 1;">0.0</div>
                    <div id="avg-stars" style="font-size: 1.5rem; margin-top: 10px;">☆☆☆☆☆</div>
                    <div id="total-reviews-count" style="font-size: 0.7rem; font-weight: 900; opacity: 0.5; margin-top: 5px;">BASED_ON_0_SIGNALS</div>
                </div>

                <div id="rating-distribution" style="display: grid; gap: 10px;">
                    <% [5,4,3,2,1].forEach(star => { %>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 0.7rem; font-weight: 900; width: 40px;"><%= star %>_STAR</span>
                            <div style="flex: 1; height: 12px; background: #eee; border: 2px solid black; position: relative; overflow: hidden;">
                                <div id="bar-<%= star %>" style="position: absolute; top: 0; left: 0; height: 100%; background: var(--neon-green); width: 0%;"></div>
                            </div>
                            <span id="percent-<%= star %>" style="font-size: 0.6rem; font-weight: 900; width: 30px;">0%</span>
                        </div>
                    <% }) %>
                </div>
            </div>

            <div class="brutal-card" style="background: black; color: white; padding: 20px; border: 4px solid black; box-shadow: 10px 10px 0px var(--neon-green);">
                <h3 style="font-size: 0.8rem; margin-bottom: 15px; background: var(--neon-green); color: black; display: inline-block; padding: 2px 10px; font-weight: 900;">[REQUIREMENT]</h3>
                <p style="font-size: 0.75rem; font-weight: 900; opacity: 0.8; line-height: 1.6;">
                    ONLY VERIFIED PURCHASERS WHO HAVE COMPLETED THE TRANSACTION CYCLE CAN TRANSMIT DATA TO THIS ARCHIVE.
                </p>
            </div>
        </div>

        <!-- REVIEWS LIST COLUMN -->
        <div id="reviews-list-container">
            <div id="empty-reviews-state" style="display: none; padding: 100px 40px; text-align: center; border: 6px dashed black; background: white;">
                <h2 style="font-weight: 950; font-size: 3rem; margin-bottom: 10px; opacity: 0.1;">NO_SIGNAL_FROM_THE_CULT_YET</h2>
                <p style="font-weight: 900; font-size: 0.8rem; opacity: 0.4;">BE_THE_FIRST_TO_INFILTRATE_THIS_ARCHIVE.</p>
            </div>
            
            <div id="reviews-list" style="display: grid; gap: 40px;">
                <!-- Review cards injected here -->
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const productId = '<%= product.id %>';
        loadReviews(productId);
    });

    function loadReviews(pId) {
        const reviews = JSON.parse(localStorage.getItem('brutal_reviews') || '[]')
            .filter(r => String(r.productId) === String(pId))
            .sort((a,b) => b.id - a.id);

        const list = document.getElementById('reviews-list');
        const empty = document.getElementById('empty-reviews-state');

        if (reviews.length === 0) {
            empty.style.display = 'block';
            list.style.display = 'none';
        } else {
            empty.style.display = 'none';
            list.style.display = 'grid';
            
            list.innerHTML = '';
            reviews.forEach(review => {
                const card = document.createElement('div');
                card.className = 'brutal-card';
                card.style.background = 'white';
                card.style.padding = '40px';
                card.style.border = '4px solid black';
                card.style.boxShadow = '12px 12px 0px black';
                
                const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
                const date = new Date(review.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

                card.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 40px; height: 40px; background: black; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 950; border: 3px solid black;">${review.username[0]}</div>
                                <div>
                                    <span style="font-weight: 950; font-size: 1.2rem; text-transform: uppercase; display: block; line-height: 1;">${review.username}</span>
                                    <span style="font-size: 0.6rem; font-weight: 900; opacity: 0.4; margin-top: 5px; display: block;">TIMESTAMP: ${date}</span>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 1.5rem; line-height: 1; margin-bottom: 8px;">${stars}</div>
                            <span style="background: var(--neon-green); color: black; padding: 2px 10px; font-size: 0.6rem; font-weight: 950; border: 2px solid black; display: inline-block;">VERIFIED_PURCHASE</span>
                        </div>
                    </div>
                    <div style="border-top: 4px solid black; padding-top: 25px;">
                        <p style="font-weight: 900; font-size: 1.3rem; line-height: 1.3; margin: 0; font-style: italic;">"${review.text}"</p>
                    </div>
                `;
                list.appendChild(card);
            });
        }

        updateStats(reviews);
    }

    function updateStats(reviews) {
        if (reviews.length === 0) {
            document.getElementById('avg-rating').innerText = '0.0';
            document.getElementById('avg-stars').innerText = '☆☆☆☆☆';
            document.getElementById('total-reviews-count').innerText = 'BASED_ON_0_SIGNALS';
            return;
        }

        const total = reviews.length;
        const sum = reviews.reduce((acc, r) => acc + r.rating, 0);
        const avg = (sum / total).toFixed(1);

        document.getElementById('avg-rating').innerText = avg;
        document.getElementById('total-reviews-count').innerText = `BASED_ON_${total}_SIGNALS`;
        
        const avgRound = Math.round(avg);
        document.getElementById('avg-stars').innerText = '★'.repeat(avgRound) + '☆'.repeat(5 - avgRound);

        // Distribution
        const counts = {1:0, 2:0, 3:0, 4:0, 5:0};
        reviews.forEach(r => counts[r.rating]++);

        [1,2,3,4,5].forEach(star => {
            const pct = Math.round((counts[star] / total) * 100);
            document.getElementById(`bar-${star}`).style.width = `${pct}%`;
            document.getElementById(`percent-${star}`).innerText = `${pct}%`;
        });
    }
</script>
