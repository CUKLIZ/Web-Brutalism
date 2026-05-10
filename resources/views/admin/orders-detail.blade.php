@extends('admin.layout')

@section('content')

{{-- HEADER --}}
<div style="margin-bottom: 40px; position: relative;">
    <div style="position: absolute; top: -30px; left: 0; font-size: 0.55rem; font-weight: 900; color: #888;">[STATUS: ONLINE] [SYNC: OK] [ENCRYPTION: ACTIVE]</div>
    <div class="flex" style="align-items: flex-end; gap: 15px;">
        <h1 style="font-size: 4rem; font-weight: 900; line-height: 0.8; letter-spacing: -3px; margin: 0;">ORDER_DETAIL</h1>
        <div style="width: 120px; height: 8px; background: #000; margin-bottom: 6px;"></div>
    </div>
    <p class="brutal-font" style="font-size: 1.1rem; background: #000; color: var(--neon-green); display: inline-block; padding: 6px 15px; margin-top: 20px; font-weight: 900; transform: skewX(-10deg);">
        [TRANSACTION_ID: {{ $order->order_code ?? '#' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}]
    </p>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">

    {{-- LEFT --}}
    <div style="display: grid; gap: 30px;">

        {{-- STATUS --}}
        @php
            $statusBg = match($order->status) {
                'paid'      => 'var(--neon-green)',
                'completed' => '#00ff88',
                'pending'   => 'var(--accent-yellow)',
                'expired'   => '#FF0000',
                'cancelled' => '#1a1a2e',
                default     => '#ccc',
            };
            $statusLabel = match($order->status) {
                'paid'      => 'PAID_CONFIRMED',
                'completed' => 'COMPLETED',
                'pending'   => 'PENDING_PAYMENT',
                'expired'   => 'ORDER_EXPIRED',
                'cancelled' => 'ORDER_CANCELLED',
                default     => 'UNKNOWN',
            };
            $statusMsg = match($order->status) {
                'paid'      => 'ASSETS_SECURED. PREPARING_FOR_DISPATCH.',
                'completed' => 'ORDER_HAS_BEEN_DELIVERED.',
                'pending'   => 'WAITING_FOR_GATEWAY_SIGNAL.',
                'expired'   => 'TRANSACTION_VOID. RE-INITIATE_ORDER.',
                'cancelled' => 'ORDER_HAS_BEEN_CANCELLED_BY_USER.',
                default     => 'CONTACT_SUPPORT.',
            };
            $statusTextColor = in_array($order->status, ['expired', 'cancelled']) ? 'color: white;' : 'color: black;';
        @endphp

        <div class="admin-stat-card" style="background: {{ $statusBg }}; {{ $statusTextColor }}">
            <div style="position: absolute; top: 0; right: 0; background: #000; color: var(--neon-green); padding: 2px 10px; font-size: 0.5rem; font-weight: 900;">SYS_STATUS_MODULE</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 10px; font-weight: 900;">STATUS: {{ $statusLabel }}</h2>
            <p style="font-weight: 900; margin-top: 15px; opacity: 0.8;">{{ $statusMsg }}</p>

            @if ($order->status === 'completed')
                <div style="margin-top: 20px; border: 4px solid black; background: white; color: black; padding: 12px 20px; display: inline-block; font-weight: 900; font-size: 0.9rem;">
                    ✓ DELIVERED_ON: {{ \Carbon\Carbon::parse($order->updated_at)->format('Y-m-d') }}
                </div>
            @endif

            @if ($order->status === 'paid')
                <form id="complete-order-form" action="{{ route('admin.orders.complete', $order->id) }}" method="POST" style="display: inline-block; margin-top: 20px;">
                    @csrf
                    @method('PATCH')
                </form>
                <button type="button"
                    onclick="window.BrutalModal.confirm(
                        'MARK_AS_COMPLETE?',
                        'ORDER {{ $order->order_code }} WILL BE MARKED AS COMPLETED. THIS ACTION CANNOT BE UNDONE.',
                        () => document.getElementById('complete-order-form').submit(),
                        'CONFIRM_COMPLETE',
                        'CANCEL'
                    )"
                    style="background: black; color: var(--neon-green); border: 3px solid black; padding: 10px 20px; font-weight: 900; font-size: 0.9rem; cursor: pointer; margin-top: 20px; box-shadow: 4px 4px 0px black; display: block;">
                    ⚡ MARK_AS_COMPLETED
                </button>
            @endif
        </div>

        {{-- MANIFEST --}}
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ MANIFEST_DETAILS ]</div>

            <div style="display: grid; gap: 15px;">
                @foreach ($order->items as $item)
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid rgba(0,0,0,0.1); padding-bottom: 12px;">
                        <div>
                            <div style="font-weight: 900; font-size: 1rem;">{{ strtoupper($item->product->name) }}</div>
                            <div style="font-size: 0.75rem; font-weight: 900; opacity: 0.5; margin-top: 3px;">
                                @if ($item->size)
                                    [SIZE: {{ $item->size->name }}]
                                @endif
                                [QTY: {{ $item->quantity }}]
                            </div>
                        </div>
                        <div style="font-weight: 900; font-size: 1rem;">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 4px solid black; margin-top: 10px;">
                <h2 style="margin: 0; font-size: 1.5rem;">TOTAL_VALUE:</h2>
                <h2 style="margin: 0; font-size: 1.5rem;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
            </div>
        </div>

        {{-- DISPATCH POINT --}}
        <div class="admin-stat-card" style="background: #f5f5f5;">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ DISPATCH_POINT ]</div>

            @if ($order->address)
                <div style="font-weight: 900; font-size: 1.2rem; margin-bottom: 8px;">
                    {{ strtoupper($order->address->recipient_name) }}
                </div>
                <div style="font-weight: 700; opacity: 0.7; margin-bottom: 6px; font-size: 0.9rem;">
                    SECTOR: {{ $order->address->street }}, {{ $order->address->city }}, {{ $order->address->postal_code }}
                </div>
                <div style="font-weight: 700; opacity: 0.7; margin-bottom: 6px; font-size: 0.9rem;">
                    PHONE: {{ $order->address->phone }}
                </div>
            @else
                <div style="font-weight: 900; opacity: 0.5;">[NO_ADDRESS_DATA]</div>
            @endif

            <div style="font-weight: 700; opacity: 0.7; margin-top: 10px; font-size: 0.9rem;">
                PAYMENT: {{ strtoupper($order->payment_method ?? '-') }}
                @if ($order->bank)
                    ({{ strtoupper($order->bank) }})
                @endif
            </div>
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div style="display: grid; gap: 20px; position: sticky; top: 30px;">

        {{-- BACK BUTTON --}}
        <a href="{{ route('admin.orders') }}"
           style="display: block; text-align: center; background: black; color: var(--neon-green); border: 4px solid var(--neon-green); padding: 15px 0; font-weight: 900; font-size: 1rem; text-decoration: none; box-shadow: 4px 4px 0px var(--neon-green);">
            &laquo; BACK_TO_LOG
        </a>

        {{-- USER INFO --}}
        <div class="admin-stat-card" style="background: #000; color: #fff;">
            <div style="background: var(--neon-green); color: #000; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ USER_NODE ]</div>
            <div style="display: grid; gap: 12px;">
                <div>
                    <span style="font-size: 0.65rem; font-weight: 900; color: #555; display: block;">USERNAME</span>
                    <span style="font-weight: 900; font-size: 1rem; color: var(--neon-green);">{{ strtoupper($order->user->username ?? 'N/A') }}</span>
                </div>
                <div>
                    <span style="font-size: 0.65rem; font-weight: 900; color: #555; display: block;">EMAIL</span>
                    <span style="font-weight: 900; font-size: 0.85rem;">{{ $order->user->email ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        {{-- ORDER INFO --}}
        <div class="admin-stat-card" style="background: #000; color: #fff;">
            <div style="background: var(--neon-green); color: #000; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ ORDER_INFO ]</div>
            <div style="display: grid; gap: 12px;">
                <div>
                    <span style="font-size: 0.65rem; font-weight: 900; color: #555; display: block;">ORDER_DATE</span>
                    <span style="font-weight: 900; font-size: 0.9rem;">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div>
                    <span style="font-size: 0.65rem; font-weight: 900; color: #555; display: block;">LAST_UPDATE</span>
                    <span style="font-weight: 900; font-size: 0.9rem;">{{ $order->updated_at->format('Y-m-d H:i') }}</span>
                </div>
                <div>
                    <span style="font-size: 0.65rem; font-weight: 900; color: #555; display: block;">TOTAL_ITEMS</span>
                    <span style="font-weight: 900; font-size: 0.9rem;">{{ $order->items->count() }}_ITEM(S)</span>
                </div>
                <div>
                    <span style="font-size: 0.65rem; font-weight: 900; color: #555; display: block;">PAYMENT_METHOD</span>
                    <span style="font-weight: 900; font-size: 0.9rem;">
                        {{ strtoupper($order->payment_method ?? '-') }}
                        @if ($order->bank) ({{ strtoupper($order->bank) }}) @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- NOTICE --}}
        <div class="admin-stat-card" style="background: #111; color: #fff; border-color: #333;">
            <h3 style="font-size: 0.9rem; margin-bottom: 10px; color: #FF0000;">[⚠ ADMIN_NOTICE]</h3>
            <p style="font-size: 0.75rem; font-weight: 700; opacity: 0.6; line-height: 1.6;">
                DO NOT SHARE TRANSACTION IDS WITH EXTERNAL NODES. ALL ACTIONS ARE LOGGED AND MONITORED.
            </p>
        </div>

    </div>
</div>

@endsection