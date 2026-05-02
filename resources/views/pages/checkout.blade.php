<% layout('layout') %>

<section class="container" style="padding: 60px 0;">
    <h1 style="font-size: 5rem; margin-bottom: 40px; text-align: center;">CHECKOUT_PAYMENT</h1>
    
    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 40px;">
        <div class="brutal-card">
            <h2 style="margin-bottom: 30px;">SECURE_TRANSACTION</h2>
            <form>
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">FULL NAME</label>
                    <input type="text" class="brutal-border" style="width: 100%; padding: 15px; font-size: 1.2rem;" placeholder="JOHN_DOE_EXAMPLE">
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">SELECT ADDRESS</label>
                    <select class="brutal-border" style="width: 100%; padding: 15px; font-size: 1rem; font-family: inherit; font-weight: 900; background: white; appearance: none; cursor: pointer;">
                        <option value="home">HOME - Street of Ashes 123</option>
                        <option value="office">OFFICE - Neo District 45</option>
                        <option value="vault">VAULT_LAB - Sector 7G, Industrial Way</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">PAYMENT METHOD</label>
                    <select name="payment_method" id="payment_method" class="brutal-border" style="width: 100%; padding: 15px; font-size: 1.2rem; font-family: inherit; font-weight: 900; background: white; appearance: none; cursor: pointer;">
                        <option value="">-- SELECT_PAYMENT --</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="qris">QRIS</option>
                        <option value="dana">DANA</option>
                        <option value="ovo">OVO</option>
                        <option value="gopay">GoPay</option>
                    </select>
                </div>

                <!-- Conditional Payment Details -->
                <div id="bank_selection" style="display: none; margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">SELECT BANK</label>
                    <select name="bank" class="brutal-border" style="width: 100%; padding: 15px; font-size: 1.2rem; font-family: inherit; font-weight: 900; background: white; appearance: none; cursor: pointer;">
                        <option value="bca">BCA</option>
                        <option value="bri">BRI</option>
                        <option value="mandiri">Mandiri</option>
                        <option value="bni">BNI</option>
                    </select>
                </div>

                <div id="qris_placeholder" style="display: none; margin-bottom: 20px;">
                    <div class="brutal-border" style="width: 100%; height: 200px; background: #fff; display: flex; align-items: center; justify-content: center;">
                        <span style="font-weight: 900; opacity: 0.5;">[QR_CODE_PLACEHOLDER]</span>
                    </div>
                </div>

                <div id="redirect_msg" style="display: none; margin-bottom: 20px;">
                    <p style="font-weight: 900; font-size: 0.9rem; color: var(--brutal-black);">"You will be redirected after payment"</p>
                </div>

                <script>
                    document.getElementById('payment_method').addEventListener('change', function() {
                        const method = this.value;
                        document.getElementById('bank_selection').style.display = method === 'bank_transfer' ? 'block' : 'none';
                        document.getElementById('qris_placeholder').style.display = method === 'qris' ? 'block' : 'none';
                        document.getElementById('redirect_msg').style.display = ['dana', 'ovo', 'gopay'].includes(method) ? 'block' : 'none';
                    });
                </script>
                <button type="button" class="brutal-button" style="width: 100%; font-size: 2rem; background: var(--accent-pink); margin-top: 20px;">PAY NOW</button>
            </form>
        </div>
        
        <div class="brutal-card" style="height: fit-content; background: #e0e0e0;">
            <h3 style="margin-bottom: 20px;">MANIFEST</h3>
            <div class="flex-between" style="margin-bottom: 10px;">
                <span>BRUTAL TEE</span>
                <span><%= formatPrice(675000) %></span>
            </div>
            <div class="flex-between" style="margin-bottom: 10px;">
                <span>VOID CAPSULE</span>
                <span><%= formatPrice(1800000) %></span>
            </div>
            <hr style="border: 2px solid black; margin: 20px 0;">
            <div class="flex-between">
                <h2 style="margin: 0;">TOTAL:</h2>
                <h2 style="margin: 0;"><%= formatPrice(2475000) %></h2>
            </div>
        </div>
    </div>
</section>
