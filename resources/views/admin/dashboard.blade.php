@extends('admin.layout')

@section('content')

<div class="admin-hero-module" style="margin-bottom: 50px; border: 4px solid #000; box-shadow: 12px 12px 0px #000; background: #000; overflow: hidden; position: relative; height: 250px;">
    <img src="{{ asset('images/admin_hero.jpg') }}" alt="System Dashboard Alpha"
         onerror="this.src='https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2000&auto=format&fit=crop'"
         style="width: 100%; height: 100%; object-fit: cover; opacity: 0.7; filter: grayscale(1) contrast(1.2);">

    <div style="position: absolute; bottom: 20px; right: 20px; background: var(--neon-green); color: #000; padding: 10px 20px; font-weight: 900; border: 3px solid #000; box-shadow: 6px 6px 0px #000;">
        [MODULE_STATUS: DATA_VIS_v2.0]
    </div>

    <div style="position: absolute; top: 20px; left: 20px; background: rgba(0,0,0,0.8); color: #fff; padding: 5px 12px; font-size: 0.6rem; font-weight: 900; border: 1px solid var(--neon-green);">
        CORE_DASH_IMAGE_BUFFER :: LOADED
    </div>
</div>

<div style="margin-bottom: 50px; position: relative;">
    <div style="position: absolute; top: -30px; left: 0; font-size: 0.55rem; font-weight: 900; color: #888;">[STATUS: ONLINE] [SYNC: OK] [ENCRYPTION: ACTIVE]</div>
    <div class="flex" style="align-items: flex-end; gap: 15px;">
        <h1 style="font-size: 4rem; font-weight: 900; line-height: 0.8; letter-spacing: -3px; margin: 0;">COMMAND_CENTER</h1>
        <div style="width: 120px; height: 8px; background: #000; margin-bottom: 6px;"></div>
    </div>
    <p class="brutal-font" style="font-size: 1.1rem; background: #000; color: var(--neon-green); display: inline-block; padding: 6px 15px; margin-top: 20px; font-weight: 900; transform: skewX(-10deg);">
        [SYSTEM_STABLE_V2.0.78]
    </p>
</div>

{{-- STAT CARDS --}}
<div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 25px; margin-bottom: 50px;">
    <div class="admin-stat-card">
        <div style="position: absolute; top: 0; right: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">LIVE_DATA</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid #000; display: inline-block;">[TOTAL_PRODUCTS]</p>
        <h2 style="font-size: 3.5rem; line-height: 1; margin: 0; font-weight: 900;">{{ $totalProducts }}</h2>
    </div>
    <div class="admin-stat-card" style="background: var(--neon-green);">
        <div style="position: absolute; top: 0; right: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">ACTIVE_TX</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid #000; display: inline-block;">[TOTAL_ORDERS]</p>
        <h2 style="font-size: 3.5rem; line-height: 1; margin: 0; font-weight: 900;">{{ $totalOrders }}</h2>
    </div>
    <div class="admin-stat-card" style="background: #000; color: #fff; border-color: var(--neon-green);">
        <div style="position: absolute; top: 0; right: 0; background: var(--neon-green); color: #000; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">SHIPPED</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid var(--neon-green); display: inline-block;">[ITEMS_SOLD]</p>
        <h2 style="font-size: 3.5rem; line-height: 1; margin: 0; font-weight: 900; color: var(--neon-green);">{{ $itemsSold }}</h2>
    </div>
    <div class="admin-stat-card" style="background: var(--accent-yellow);">
        <div style="position: absolute; bottom: 0; right: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">IDR_VAL</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid #000; display: inline-block;">[TOTAL_REVENUE]</p>
        <h2 style="font-size: 2rem; line-height: 1; margin: 0; font-weight: 900;">
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </h2>
    </div>
</div>

{{-- REVENUE CHART --}}
<div class="admin-stat-card" style="margin-bottom: 50px; padding: 35px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            <h3 style="font-size: 1.5rem; border-left: 8px solid #000; padding-left: 15px; line-height: 1; margin: 0; font-weight: 900;">REVENUE_METRICS_7D</h3>
            <p style="font-size: 0.65rem; font-weight: 900; margin-top: 8px; opacity: 0.5;">[DATA_STREAM_ACTIVE] [RANGE: LAST_7_DAYS]</p>
        </div>
        <div style="background: #000; color: var(--neon-green); padding: 4px 12px; font-weight: 900; font-size: 0.75rem;">SYNC_OK :: NODE_ALPHA</div>
    </div>

    @php
        $maxRevenue = $revenueChart->max('revenue') ?: 1;
    @endphp

    <div style="height: 300px; background: #000; border: 4px solid #000; display: flex; align-items: flex-end; gap: 12px; padding: 40px 25px 50px 55px; position: relative;">

        {{-- Y-AXIS --}}
        <div style="position: absolute; left: 10px; top: 30px; bottom: 50px; display: flex; flex-direction: column; justify-content: space-between; font-size: 0.55rem; font-weight: 900; color: #555; text-align: right; width: 40px;">
            <div>100%</div>
            <div>80%</div>
            <div>60%</div>
            <div>40%</div>
            <div>20%</div>
            <div>0%</div>
        </div>

        {{-- GRID LINES --}}
        @foreach ([0, 20, 40, 60, 80] as $pct)
            <div style="position: absolute; top: calc({{ $pct }}% + 30px); left: 55px; right: 25px; border-top: 1px dashed #222; pointer-events: none;"></div>
        @endforeach
        <div style="position: absolute; bottom: 50px; left: 55px; right: 25px; border-top: 1px solid #444; pointer-events: none;"></div>

        {{-- BARS --}}
        @foreach ($revenueChart as $data)
            @php
                $heightPct = $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 100 : 0;
                $isHighest = $data['revenue'] > 0 && $data['revenue'] === $revenueChart->max('revenue');
                $isToday   = $loop->last;
            @endphp
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; height: 100%; justify-content: flex-end; position: relative; z-index: 1;">

                {{-- Value label --}}
                <div style="font-size: 0.48rem; font-weight: 900; color: {{ $isHighest ? 'var(--neon-green)' : '#666' }}; margin-bottom: 4px; text-align: center; min-height: 12px; white-space: nowrap;">
                    {{ $data['revenue'] > 0 ? 'Rp ' . number_format($data['revenue'] / 1000000, 1) . 'M' : '-' }}
                </div>

                {{-- Bar --}}
                <div style="
                    width: 100%;
                    height: {{ max($heightPct, 2) }}%;
                    background: {{ $isHighest ? 'var(--neon-green)' : ($isToday ? '#555' : ($data['revenue'] > 0 ? '#333' : '#1a1a1a')) }};
                    border: 1px solid {{ $isHighest ? '#000' : '#444' }};
                    {{ $isHighest ? 'box-shadow: 0px 0px 20px rgba(163, 255, 0, 0.4);' : '' }}
                "></div>

                {{-- Date label --}}
                <div style="font-size: 0.48rem; font-weight: 900; color: {{ $isToday ? '#fff' : '#666' }}; margin-top: 8px; text-align: center; white-space: nowrap; position: absolute; bottom: -30px;">
                    {{ $isToday ? 'TODAY' : $data['label'] }}
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
        <div style="background: #eee; padding: 12px; border: 2px solid #000; font-size: 0.65rem; font-weight: 900;">
            [BEST_DAY]: {{ $revenueChart->sortByDesc('revenue')->first()['label'] }}
        </div>
        <div style="background: #eee; padding: 12px; border: 2px solid #000; font-size: 0.65rem; font-weight: 900;">
            [AVG_DAILY]: Rp {{ number_format($revenueChart->avg('revenue'), 0, ',', '.') }}
        </div>
        <div style="background: #eee; padding: 12px; border: 2px solid #000; font-size: 0.65rem; font-weight: 900;">
            [TOTAL_7D]: Rp {{ number_format($revenueChart->sum('revenue'), 0, ',', '.') }}
        </div>
    </div>
</div>

{{-- RECENT ORDERS --}}
<section style="margin-bottom: 50px;">
    <div class="flex-between" style="border-bottom: 6px solid #000; padding-bottom: 15px; margin-bottom: 30px;">
        <h2 style="font-size: 2.5rem; font-weight: 900; margin: 0; line-height: 1;">RECENT_TRANSACTIONS</h2>
        <a href="/admin/orders" style="font-size: 0.8rem; font-weight: 900; color: #000;">FULL_LOG -></a>
    </div>

    <div style="border: 4px solid #000; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; font-weight: 900;">
            <thead>
                <tr style="background: #000; color: var(--neon-green); font-size: 0.7rem;">
                    <th style="padding: 12px 15px; text-align: left;">ORDER_ID</th>
                    <th style="padding: 12px 15px; text-align: left;">USER</th>
                    <th style="padding: 12px 15px; text-align: left;">TOTAL</th>
                    <th style="padding: 12px 15px; text-align: left;">STATUS</th>
                    <th style="padding: 12px 15px; text-align: left;">DATE</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    @php
                        $statusColor = match($order->status) {
                            'paid'      => 'var(--neon-green)',
                            'completed' => '#00ff88',
                            'pending'   => 'var(--accent-yellow)',
                            'cancelled' => '#FF6B00',
                            'expired'   => '#FF0000',
                            default     => '#ccc',
                        };
                        $statusTextColor = in_array($order->status, ['expired', 'cancelled']) ? 'color: #fff;' : 'color: #000;';
                    @endphp
                    <tr style="border-bottom: 2px solid #000; font-size: 0.8rem; {{ $loop->even ? 'background: #f5f5f5;' : '' }}">
                        <td style="padding: 12px 15px; font-size: 0.75rem;">{{ $order->order_code }}</td>
                        <td style="padding: 12px 15px;">{{ strtoupper($order->user->username ?? 'N/A') }}</td>
                        <td style="padding: 12px 15px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td style="padding: 12px 15px;">
                            <span style="background: {{ $statusColor }}; {{ $statusTextColor }} padding: 2px 8px; font-size: 0.65rem; border: 2px solid #000;">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td style="padding: 12px 15px; opacity: 0.6; font-size: 0.7rem;">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; opacity: 0.5; font-weight: 900;">[NO_TRANSACTIONS_FOUND]</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- PRODUCT PREVIEW --}}
<section style="margin-bottom: 50px;">
    <div class="flex-between" style="border-bottom: 6px solid #000; padding-bottom: 15px; margin-bottom: 30px;">
        <h2 style="font-size: 2.5rem; font-weight: 900; margin: 0; line-height: 1;">ACTIVE_INVENTORY_ALPHA</h2>
        <a href="/admin/products" style="font-size: 0.8rem; font-weight: 900; color: #000;">FULL_DATABASE -></a>
    </div>

    <div class="grid product-grid" id="admin-product-list" style="gap: 30px;">
        @forelse ($products as $product)
            <div class="admin-product-wrapper"
                 data-search="{{ $product->id }} {{ strtolower($product->name) }} {{ strtolower($product->category) }}">
                <x-product-card :product="$product" :isAdmin="true" />
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; font-weight: 900; opacity: 0.4;">[NO_PRODUCTS_FOUND]</div>
        @endforelse
    </div>
</section>
<script>
document.addEventListener('click', (e) => {
    const btn = e.target.closest('.delete-product-btn');
    if (!btn) return;

    const { id, name } = btn.dataset;

    window.BrutalModal.confirm(
        'PURGE_PRODUCT?',
        `THIS ACTION WILL REMOVE [${name}] FROM THE VAULT. ⚠ PERMANENT — ✕ NO_RECOVERY`,
        () => {
                fetch(`/admin/products/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: '_method=DELETE'
            })
            .then(res => {
                if (res.ok || res.redirected) {
                    const card = btn.closest('.admin-product-wrapper');
                    card.style.transition = 'opacity 0.3s, transform 0.3s';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => card.remove(), 300);

                    window.BrutalModal.confirm(
                        'PRODUCT_PURGED',
                        `[${name}] HAS BEEN REMOVED FROM THE VAULT.`,
                        null,
                        'OK',
                        null
                    );
                }
            });
        },
        'CONFIRM_PURGE',
        'CANCEL_OPS'
    );
});
</script>

@endsection