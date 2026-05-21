<% layout('layout') %>

<div id="order-loading" class="container" style="padding: 100px 0; text-align: center;">
    <h1 style="font-size: 3rem;">SYNCING_VAULT_DATA...</h1>
</div>

<div id="order-content" class="container" style="padding: 60px 0; display: none;">
    <div style="text-align: center; margin-bottom: 50px;">
        <h1 style="font-size: 5rem; line-height: 1; margin-bottom: 10px;">ORDER_CONFIRMED</h1>
        <div style="display: inline-block; background: var(--brutal-black); color: white; padding: 5px 20px; font-weight: 900; letter-spacing: 2px;">
            TRANSACTION_ID: <span id="display-id">--</span>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">
        <div class="grid" style="gap: 40px;">
            <!-- Status Section -->
            <section id="status-card" class="brutal-card">
                <h2 style="font-size: 2.5rem; margin-bottom: 10px;">STATUS: <span id="display-status">--</span></h2>
                <div id="countdown-container" style="display: none;">
                    <p style="font-weight: 900; margin-bottom: 20px;">COMPLETE PAYMENT BEFORE VOID EXPIRES:</p>
                    <div id="countdown" style="font-size: 3rem; font-weight: 900; font-family: var(--font-mono); border: 4px solid black; background: white; padding: 10px 20px; display: inline-block;">
                        --:--
                    </div>
                </div>
                <p id="status-msg" style="font-weight: 900;"></p>
            </section>

            <!-- Order Manifest -->
            <section class="brutal-card">
                <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">MANIFEST_DETAILS</h2>
                <div id="manifest-items" style="display: grid; gap: 15px;">
                    <!-- Items injected here -->
                </div>
                <div class="flex-between" style="padding-top: 10px; border-top: 4px solid black; margin-top: 15px;">
                    <h2 style="margin: 0;">TOTAL_VALUE:</h2>
                    <h2 style="margin: 0;" id="display-total">--</h2>
                </div>
            </section>

            <!-- Shipping Info -->
            <section class="brutal-card" style="background: var(--gallery-white);">
                <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">DISPATCH_POINT</h2>
                <div id="display-name" style="font-weight: 900; font-size: 1.2rem; margin-bottom: 5px;">--</div>
                <div id="display-address" style="font-weight: 700; opacity: 0.7; margin-bottom: 10px;">SECTOR: --</div>
                <div id="display-method" style="font-weight: 700; opacity: 0.7;">METHOD: --</div>
            </section>
        </div>

        <!-- Sidebar Actions -->
        <div class="grid" style="gap: 20px; position: sticky; top: 100px;">
            <button id="btn-simulate" onclick="simulatePayment()" class="brutal-button" style="display: none; width: 100%; background: var(--neon-green); font-size: 1.2rem;">SIMULATE_PAYMENT_SUCCESS</button>
            
            <a href="/products" class="brutal-button" style="width: 100%; text-align: center; text-decoration: none; display: block; background: var(--accent-pink); font-size: 1.2rem;">BACK_TO_VAULT</a>
            <a href="/profile" class="brutal-button" style="width: 100%; text-align: center; text-decoration: none; display: block; background: white; font-size: 1.2rem;">VIEW_PROFILE</a>
            
            <div class="brutal-card" style="background: var(--brutal-black); color: white; margin-top: 20px;">
                <h3 style="font-size: 1.2rem; margin-bottom: 10px;">[NOTICE]</h3>
                <p style="font-size: 0.8rem; font-weight: 700; opacity: 0.7;">DO NOT SHARE TRANSACTION IDS WITH EXTERNAL NODES.</p>
            </div>
        </div>
    </div>
</div>

<!-- REVIEW MODAL -->
<div id="review-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div class="brutal-card" style="max-width: 500px; width: 90%; background: white; padding: 40px; position: relative;">
        <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.6rem; margin-bottom: 20px;">[ FEEDBACK_PROTOCOL_V1 ]</div>
        <h2 id="rv-product-name" style="font-size: 2.5rem; line-height: 1; margin-bottom: 30px; letter-spacing: -2px;">PRODUCT_NAME</h2>
        
        <div style="margin-bottom: 30px;">
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 10px;">STAR_RATING</label>
            <div style="display: flex; gap: 5px;">
                <% [1,2,3,4,5].forEach(i => { %>
                    <button class="rv-star brutal-button" onclick="setRating(<%= i %>)" style="width: 50px; height: 50px; font-size: 1.5rem; display: flex; align-items: center; justify-content: center;">★</button>
                <% }) %>
            </div>
        </div>

        <div style="margin-bottom: 40px;">
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 10px;">REVIEW_TEXT_LOG</label>
            <textarea id="review-text" placeholder="SHARE_YOUR_VOICE..." 
                      style="width: 100%; height: 150px; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0; resize: none;"></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <button onclick="submitReview()" class="brutal-button" style="background: var(--neon-green); font-size: 1.2rem; padding: 15px 0;">SUBMIT_REVIEW</button>
            <button onclick="closeReviewModal()" class="brutal-button" style="background: white; font-size: 1.2rem; padding: 15px 0;">CANCEL</button>
        </div>
    </div>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('id');
    let currentOrder = null;

    function formatCurrency(val) {
        return 'Rp ' + val.toLocaleString('id-ID');
    }

    function loadOrder() {
        const orders = JSON.parse(localStorage.getItem('brutal_orders') || '[]');
        currentOrder = orders.find(o => o.id === orderId);

        if (!currentOrder) {
            document.getElementById('order-loading').innerHTML = '<h1 style="font-size: 3rem; color: #FF0000;">ERROR: ORDER_NOT_FOUND</h1>';
            return;
        }

        document.getElementById('order-loading').style.display = 'none';
        document.getElementById('order-content').style.display = 'block';

        // Hydrate
        document.getElementById('display-id').innerText = currentOrder.id;
        document.getElementById('display-total').innerText = formatCurrency(currentOrder.total);
        document.getElementById('display-name').innerText = currentOrder.fullName;
        document.getElementById('display-address').innerText = 'SECTOR: ' + currentOrder.address;
        document.getElementById('display-method').innerText = 'METHOD: ' + currentOrder.paymentMethod.toUpperCase() + (currentOrder.bank ? ` (${currentOrder.bank.toUpperCase()})` : '');

        const manifest = document.getElementById('manifest-items');
        manifest.innerHTML = '';
        currentOrder.items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'flex-column';
            div.style.borderBottom = '2px solid rgba(0,0,0,0.1)';
            div.style.paddingBottom = '15px';
            div.style.marginBottom = '15px';
            
            div.innerHTML = `
                <div class="flex-between">
                    <div style="font-weight: 900;">${item.name}</div>
                    <div style="font-weight: 900;">${formatCurrency(item.price)}</div>
                </div>
                <div id="review-btn-container-${item.id}" style="display: none; margin-top: 10px;">
                    <button onclick="openReviewModal('${item.id}', '${item.name}', '${currentOrder.id}')" 
                            class="brutal-button" 
                            style="padding: 5px 15px; font-size: 0.7rem; background: black; color: white;">
                        WRITE_REVIEW
                    </button>
                    <span id="review-done-${item.id}" style="display: none; font-size: 0.6rem; font-weight: 900; color: var(--neon-green);">[ REVIEWED_AS_ARCHIVE ]</span>
                </div>
            `;
            manifest.appendChild(div);
        });

        updateUI();
    }

    function checkExistingReviews() {
        if (!currentOrder || currentOrder.status !== 'PAID') return;
        
        const reviews = JSON.parse(localStorage.getItem('brutal_reviews') || '[]');
        currentOrder.items.forEach(item => {
            const hasReview = reviews.some(r => r.productId === item.id && r.orderId === currentOrder.id);
            const btn = document.querySelector(`#review-btn-container-${item.id} button`);
            const span = document.getElementById(`review-done-${item.id}`);
            const container = document.getElementById(`review-btn-container-${item.id}`);
            
            if (container) container.style.display = 'block';
            if (hasReview) {
                if (btn) btn.style.display = 'none';
                if (span) span.style.display = 'inline-block';
            }
        });
    }

    function updateUI() {
        const statusCard = document.getElementById('status-card');
        const displayStatus = document.getElementById('display-status');
        const statusMsg = document.getElementById('status-msg');
        const countdownContainer = document.getElementById('countdown-container');
        const btnSimulate = document.getElementById('btn-simulate');

        if (currentOrder.status === 'PENDING') {
            displayStatus.innerText = 'PENDING_PAYMENT';
            statusCard.style.background = 'var(--accent-yellow)';
            statusMsg.innerText = 'WAITING_FOR_GATEWAY_SIGNAL...';
            countdownContainer.style.display = 'block';
            btnSimulate.style.display = 'block';
            startTimer();
        } else if (currentOrder.status === 'PAID') {
            displayStatus.innerText = 'PAID_CONFIRMED';
            statusCard.style.background = 'var(--neon-green)';
            statusMsg.innerText = 'ASSETS_SECURED. PREPARING_FOR_DISPATCH.';
            countdownContainer.style.display = 'none';
            btnSimulate.style.display = 'none';
            statusCard.style.color = 'black';
            checkExistingReviews();
        } else if (currentOrder.status === 'EXPIRED') {
            displayStatus.innerText = 'ORDER_EXPIRED';
            statusCard.style.background = '#FF0000';
            statusCard.style.color = 'white';
            statusMsg.innerText = 'THE_LINK_HAS_EXPIRED. RE-INITIATE_TRANSACTION.';
            countdownContainer.style.display = 'none';
            btnSimulate.style.display = 'none';
        }
    }

    // REVIEW SYSTEM LOGIC
    let selectedRating = 0;
    let targetProduct = null;

    function openReviewModal(productId, productName, orderId) {
        targetProduct = { id: productId, name: productName, orderId: orderId };
        selectedRating = 5; // Default
        document.getElementById('rv-product-name').innerText = productName;
        document.getElementById('review-modal').style.display = 'flex';
        updateStarUI();
    }

    function setRating(r) {
        selectedRating = r;
        updateStarUI();
    }

    function updateStarUI() {
        const stars = document.querySelectorAll('.rv-star');
        stars.forEach((star, i) => {
            star.style.background = (i < selectedRating) ? 'black' : 'white';
            star.style.color = (i < selectedRating) ? 'white' : 'black';
        });
    }

    function submitReview() {
        const text = document.getElementById('review-text').value;
        if (!text || text.length < 5) {
            alert('PROTOCOL_ERROR: REVIEW_TEXT_TOO_SHORT');
            return;
        }

        const reviews = JSON.parse(localStorage.getItem('brutal_reviews') || '[]');
        const user = JSON.parse(localStorage.getItem('currentUser') || '{"username": "ANON_VOID"}');

        const newReview = {
            id: Date.now(),
            productId: targetProduct.id,
            productName: targetProduct.name,
            orderId: targetProduct.orderId,
            username: user.username,
            rating: selectedRating,
            text: text,
            date: new Date().toISOString(),
            verified: true
        };

        reviews.push(newReview);
        localStorage.setItem('brutal_reviews', JSON.stringify(reviews));

        closeReviewModal();
        checkExistingReviews();
        
        window.BrutalModal.show({
            title: 'SIGNAL_RECEIVED',
            message: 'YOUR_VOICE_HAS_JOINED_THE_ARCHIVE.',
            tag: 'TRANSMISSION_COMPLETE'
        });
    }

    function closeReviewModal() {
        document.getElementById('review-modal').style.display = 'none';
        document.getElementById('review-text').value = '';
    }

    function startTimer() {
        const expiresAt = new Date(currentOrder.expiresAt).getTime();
        
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = expiresAt - now;
            
            if (distance < 0) {
                clearInterval(timer);
                if (currentOrder.status === 'PENDING') {
                    updateStatus('EXPIRED');
                }
                return;
            }
            
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById("countdown").innerHTML = 
                (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        }, 1000);
    }

    function updateStatus(newStatus) {
        currentOrder.status = newStatus;
        const orders = JSON.parse(localStorage.getItem('brutal_orders') || '[]');
        const idx = orders.findIndex(o => o.id === currentOrder.id);
        if (idx !== -1) {
            orders[idx] = currentOrder;
            localStorage.setItem('brutal_orders', JSON.stringify(orders));
        }
        updateUI();
    }

    function simulatePayment() {
        window.BrutalModal.confirm('SIMULATE_SUCCESS?', 'THIS WILL MARK THE TRANSACTION AS PAID.', () => {
            updateStatus('PAID');
            window.BrutalModal.show({title: 'PAID_CONFIRMED', message: 'ASSETS_SECURED_IN_VAULT', tag: 'SYNC_COMPLETE'});
        }, 'SIMULATE', 'CANCEL');
    }

    window.onload = loadOrder;
</script>
