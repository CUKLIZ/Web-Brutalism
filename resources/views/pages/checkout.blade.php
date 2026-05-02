<% layout('layout') %>

<section class="container" style="padding: 60px 0;">
    <h1 style="font-size: 5rem; margin-bottom: 40px; text-align: center;">TELEPORTATION DETAILS</h1>
    
    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 40px;">
        <div class="brutal-card">
            <h2 style="margin-bottom: 30px;">SECURE YOUR LOOT</h2>
            <form>
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">ID Name</label>
                    <input type="text" class="brutal-border" style="width: 100%; padding: 15px; font-size: 1.2rem;" placeholder="VOID WALKER">
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">Void Address</label>
                    <input type="text" class="brutal-border" style="width: 100%; padding: 15px; font-size: 1.2rem;" placeholder="STREET OF ASHES 123">
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div style="margin-bottom: 20px;">
                        <label class="brutal-font" style="display: block; margin-bottom: 10px;">Credit Key Number</label>
                        <input type="text" class="brutal-border" style="width: 100%; padding: 15px; font-size: 1.2rem;" placeholder="0000 0000 0000 0000">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label class="brutal-font" style="display: block; margin-bottom: 10px;">Expiry / CVV</label>
                        <input type="text" class="brutal-border" style="width: 100%; padding: 15px; font-size: 1.2rem;" placeholder="12/25 | 666">
                    </div>
                </div>
                <button type="button" class="brutal-button" style="width: 100%; font-size: 2rem; background: var(--accent-pink); margin-top: 20px;">CONFIRM TELEPORTATION</button>
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
