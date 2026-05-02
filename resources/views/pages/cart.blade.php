@extends('layout')

@section('content')
<section class="container" style="padding: 60px 0; background: #D9D9D9; min-height: 100vh;">
    <div style="margin-bottom: 60px;">
        <h1 style="font-size: 8rem; line-height: 0.8; font-style: italic; font-weight: 900; letter-spacing: -4px;">YOUR_LOOT</h1>
        <p class="brutal-font" style="font-size: 2rem; border-bottom: 6px solid black; display: inline-block; padding-bottom: 10px;" id="item-count">[0{{ $cartItems->count() }}_ITEMS_IN_STORAGE]</p>
    </div>

    @if($cartItems->isEmpty())
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
    @else
        <div class="cart-grid">
            <div>
                @foreach($cartItems as $index => $item)
                    @php $rotation = rand(-5, 5); @endphp
                    <div class="cart-item-card" id="cart-item-{{ $item->id }}" style="transform: rotate({{ $rotation }}deg) {{ $index % 2 === 1 ? 'translate(4px, 4px)' : '' }};">
                        <img src="{{ $item->product->images->first()->image_path ?? 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80' }}" 
                             alt="{{ $item->product->name }}" 
                             class="cart-item-img" style="border: 8px solid black;">
                        <div style="padding: 20px;">
                            <span class="badge" style="background: #0000AA; color: white;">RARE_LOCKED</span>
                            <h3 style="font-size: 2.2rem; margin-top: 15px; line-height: 1;">{{ str_replace(' ', '_', $item->product->name) }}</h3>
                            <p class="brutal-font" style="font-size: 0.9rem; color: #333; margin-top: 5px;">"ARCHIVE_PIECE"</p>
                            <p class="brutal-font" style="font-size: 0.9rem; margin-top: 15px;">{{ $item->size->name }} / C_VOID_BLACK</p>
                            <h3 style="font-size: 2.2rem; margin-top: 15px; color: #000;">Rp {{ number_format($item->product->price, 0, ',', '.') }}</h3>
                        </div>
                        <div style="padding: 15px; border-left: var(--border-width) solid var(--brutal-black);">
                            <p class="brutal-font" style="font-size: 0.7rem; margin-bottom: 5px;">QTY</p>
                            <div class="qty-box">
                                <button class="qty-btn" onclick="updateQty({{ $item->id }}, {{ max(1, $item->quantity - 1) }})">-</button>
                                <input type="text" class="qty-input" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" readonly>
                                <button class="qty-btn" onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                            </div>
                            <button onclick="removeItem({{ $item->id }})" 
                                    style="width: 100%; border: var(--border-width) solid var(--brutal-black); background: black; color: white; padding: 5px; font-weight: 900; font-size: 0.6rem; margin-top: 10px; cursor: pointer;">
                                REMOVE X
                            </button>
                        </div>
                        <div style="position: absolute; right: 10px; bottom: 10px; font-size: 1.5rem; font-weight: 900; pointer-events: none; opacity: 0.1;">#{{ $item->id }}</div>
                    </div>
                @endforeach

                @php
                    $freeShipThreshold = 5000000;
                    $progress = min(100, ($subtotal / $freeShipThreshold) * 100);
                    $remaining = max(0, $freeShipThreshold - $subtotal);
                @endphp
                <div class="progress-container">
                    <div class="flex-between" style="margin-bottom: 15px;">
                        <span class="brutal-font" style="font-size: 0.9rem;">FUELING_PROGRESS</span>
                        <span class="brutal-font" style="font-size: 0.9rem; color: #0000FF;" id="progress-label">Rp {{ number_format($subtotal, 0, ',', '.') }} / Rp 5.000.000 FOR FREE SHIP</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill" style="width: {{ $progress }}%">
                            <span id="progress-text">{{ round($progress) }}%_SYNCED</span>
                        </div>
                    </div>
                    <p style="font-size: 0.6rem; font-weight: 900; margin-top: 10px;" id="remaining-text">
                        DROP ANOTHER Rp {{ number_format($remaining, 0, ',', '.') }} TO UNLOCK GLOBAL TRANSPORT AT ZERO COST.
                    </p>
                </div>
            </div>

            <!-- Summary Panel -->
            {{-- <div class="summary-panel">
                <button class="brutal-button" style="width: 100%; text-align: center; background: var(--neon-green); color: black; font-size: 1.4rem; padding: 10px 0; margin-bottom: 40px; border-width: 4px;">
                    APPLY_DISCOUNT
                </button>
                <h2 style="font-size: 3rem; font-style: italic; border-bottom: 6px solid black; padding-bottom: 10px; margin-bottom: 30px;">ORDER_TOTAL</h2>
                
                <div class="flex-between" style="margin-bottom: 15px;">
                    <span class="brutal-font">SUBTOTAL</span>
                    <span class="brutal-font" id="subtotal-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex-between" style="margin-bottom: 15px;">
                    <span class="brutal-font" style="color: #0000FF;">SHIPPING</span>
                    <span class="brutal-font" id="shipping-display">
                        @if($subtotal >= $freeShipThreshold)
                            FREE_SHIP UNLOCKED
                        @else
                            Rp 15.000
                        @endif
                    </span>
                </div>

                <div style="border-top: 6px solid black; margin: 30px 0; padding-top: 20px;">
                    <div class="flex-between">
                        <h2 style="font-size: 3rem;">TOTAL</h2>
                        <h2 style="font-size: 3rem;" id="total-display">Rp {{ number_format($subtotal + ($subtotal >= $freeShipThreshold ? 0 : 15000), 0, ',', '.') }}</h2>
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
            </div> --}}

          <!-- Summary Panel -->
<div class="summary-panel" style="background: var(--neon-green); border: 6px solid black; box-shadow: 15px 15px 0px black; padding: 30px; color: black;">
    <button class="brutal-button" style="width: 100%; text-align: center; background: black; color: white; font-size: 1.1rem; padding: 12px 0; margin-bottom: 30px; border: 4px solid black; font-weight: 900; text-transform: uppercase;">
        APPLY_DISCOUNT_CODE
    </button>
    
    <h2 style="font-size: 2rem; font-style: italic; border-bottom: 6px solid black; padding-bottom: 5px; margin-bottom: 25px; font-weight: 900; color: black;">ORDER_SUMMARY</h2>
    
    <div class="flex-between" style="margin-bottom: 12px;">
        <span class="brutal-font" style="font-weight: 900; font-size: 1rem; color: black;">SUBTOTAL</span>
        <span class="brutal-font" id="subtotal-display" style="font-weight: 900; font-size: 1rem; color: black;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
    </div>
    
    <div class="flex-between" style="margin-bottom: 12px;">
        <!-- Warna biru diganti ke hitam agar kontras di atas hijau -->
        <span class="brutal-font" style="font-weight: 900; font-size: 1rem; color: black;">SHIPPING</span>
        <span class="brutal-font" id="shipping-display" style="font-weight: 900; font-size: 0.9rem; text-align: right; color: black;">
            @if($subtotal >= $freeShipThreshold)
                [FREE_SHIPPING]
            @else
                Rp 15.000
            @endif
        </span>
    </div>

    <!-- TOTAL PRICE BOX -->
    <div style="border: 6px solid black; background: black; margin: 30px 0; padding: 20px; box-shadow: 8px 8px 0px rgba(0,0,0,0.3);">
        <div class="flex-between" style="align-items: center; flex-wrap: wrap; gap: 10px;">
            <h2 style="font-size: 1.8rem; margin: 0; color: white; font-weight: 900; letter-spacing: -1px;">TOTAL</h2>
            <h2 style="font-size: 2rem; margin: 0; color: var(--neon-green); font-weight: 900; letter-spacing: -1px;" id="total-display">
                Rp {{ number_format($subtotal + ($subtotal >= $freeShipThreshold ? 0 : 15000), 0, ',', '.') }}
            </h2>
        </div>
    </div>

    <a href="/checkout" class="brutal-button" style="width: 100%; text-align: center; background: black; color: var(--neon-green); font-size: 2.2rem; padding: 15px 0; margin-bottom: 20px; font-style: italic; display: block; text-decoration: none; border: 4px solid black; font-weight: 900; transition: 0.1s;">
        CHECKOUT_NOW
    </a>

    <div class="flex" style="gap: 8px; justify-content: center;">
        <div style="font-size: 0.7rem; padding: 4px 10px; border: 2px solid black; background: black; color: white; font-weight: 900;">APPLE_PAY</div>
        <div style="font-size: 0.7rem; padding: 4px 10px; border: 2px solid black; background: black; color: white; font-weight: 900;">CRYPTO</div>
        <div style="font-size: 0.7rem; padding: 4px 10px; border: 2px solid black; background: black; color: white; font-weight: 900;">VISA/MC</div>
    </div>

    <!-- RULES BOX -->
    <div style="margin-top: 40px; border-top: 4px solid black; padding-top: 15px;">
        <p class="brutal-font" style="font-size: 0.9rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; font-weight: 900; color: black;">
           <span style="background: black; color: var(--neon-green); width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">!</span> 
           BRUTAL_RULES:
        </p>
        <div style="font-size: 0.7rem; font-weight: 900; line-height: 1.5; color: black; text-transform: uppercase;">
            _NO_REFUNDS // _ALL_SALES_FINAL // _VOID_SYSTEMS
        </div>
    </div>
</div>
        </div>
    @endif
</section>

<script>
const csrfToken = '{{ csrf_token() }}';

async function updateQty(itemId, newQty) {
    if (newQty < 1) return;

    const res = await fetch(`/cart/update/${itemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-HTTP-Method-Override': 'PATCH'
        },
        body: JSON.stringify({ quantity: newQty })
    });

    if (res.ok) {
        const input = document.getElementById(`qty-${itemId}`);
        input.value = newQty;

        // Update the onclick values for +/- buttons
        const btns = input.closest('.qty-box').querySelectorAll('.qty-btn');
        btns[0].setAttribute('onclick', `updateQty(${itemId}, ${newQty - 1})`);
        btns[1].setAttribute('onclick', `updateQty(${itemId}, ${newQty + 1})`);

        refreshSummary();
    }
}

async function removeItem(itemId) {
    const res = await fetch(`/cart/remove/${itemId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-HTTP-Method-Override': 'DELETE'
        }
    });

    if (res.ok) {
        const card = document.getElementById(`cart-item-${itemId}`);
        card.style.transition = 'opacity 0.3s, transform 0.3s';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';
        setTimeout(() => {
            card.remove();
            refreshSummary();
            checkEmpty();
        }, 300);
    }
}

async function refreshSummary() {
    const res = await fetch('/cart/summary');
    if (!res.ok) return;
    const data = await res.json();

    document.getElementById('subtotal-display').textContent = 'Rp ' + formatRp(data.subtotal);
    document.getElementById('total-display').textContent = 'Rp ' + formatRp(data.total);
    document.getElementById('shipping-display').textContent = data.free_ship ? 'FREE_SHIP UNLOCKED' : 'Rp 15.000';
    document.getElementById('progress-fill').style.width = data.progress + '%';
    document.getElementById('progress-text').textContent = Math.round(data.progress) + '%_SYNCED';
    document.getElementById('progress-label').textContent = 'Rp ' + formatRp(data.subtotal) + ' / Rp 5.000.000 FOR FREE SHIP';
    document.getElementById('remaining-text').textContent = 'DROP ANOTHER Rp ' + formatRp(data.remaining) + ' TO UNLOCK GLOBAL TRANSPORT AT ZERO COST.';
    document.getElementById('item-count').textContent = '[0' + data.count + '_ITEMS_IN_STORAGE]';
}

function checkEmpty() {
    const cards = document.querySelectorAll('.cart-item-card');
    if (cards.length === 0) location.reload();
}

function formatRp(num) {
    return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
</script>
@endsection