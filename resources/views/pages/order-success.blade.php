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
            div.className = 'flex-between';
            div.style.borderBottom = '2px solid rgba(0,0,0,0.1)';
            div.style.paddingBottom = '10px';
            div.innerHTML = `<div style="font-weight: 900;">${item.name}</div><div style="font-weight: 900;">${formatCurrency(item.price)}</div>`;
            manifest.appendChild(div);
        });

        updateUI();
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
        } else if (currentOrder.status === 'EXPIRED') {
            displayStatus.innerText = 'ORDER_EXPIRED';
            statusCard.style.background = '#FF0000';
            statusCard.style.color = 'white';
            statusMsg.innerText = 'THE_LINK_HAS_EXPIRED. RE-INITIATE_TRANSACTION.';
            countdownContainer.style.display = 'none';
            btnSimulate.style.display = 'none';
        }
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
