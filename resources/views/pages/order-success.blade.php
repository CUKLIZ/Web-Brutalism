@extends('layout')

@section('content')

<div class="container" style="padding: 60px 0;">
    <div style="text-align: center; margin-bottom: 50px;">
        <h1 style="font-size: 5rem; line-height: 1; margin-bottom: 10px;">ORDER_CONFIRMED</h1>
        <div style="display: inline-block; background: var(--brutal-black); color: white; padding: 5px 20px; font-weight: 900; letter-spacing: 2px;">
            TRANSACTION_ID: {{ $order->order_code }}
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">
        <div class="grid" style="gap: 40px;">

            {{-- Status Section --}}
            @php
                $statusBg = match($order->status) {
                    'paid'      => 'var(--neon-green)',
                    'pending'   => 'var(--accent-yellow)',
                    'completed' => 'var(--neon-green)',
                    'expired'   => '#FF0000',
                    'cancelled' => '#FF0000',
                    default     => '#FF0000',
                };
                $statusLabel = match($order->status) {
                    'paid'      => 'PAID_CONFIRMED',
                    'pending'   => 'PENDING_PAYMENT',
                    'completed' => 'COMPLETED',
                    'expired'   => 'ORDER_EXPIRED',
                    'cancelled' => 'ORDER_CANCELLED',
                    default     => 'UNKNOWN',
                };
                $statusMsg = match($order->status) {
                    'paid'      => 'ASSETS_SECURED. PREPARING_FOR_DISPATCH.',
                    'pending'   => 'WAITING_FOR_GATEWAY_SIGNAL...',
                    'completed' => 'ORDER HAS BEEN DELIVERED.',
                    'expired'   => 'TRANSACTION VOID. RE-INITIATE ORDER.',
                    'cancelled' => 'TRANSACTION VOIDED BY USER.',
                    default     => 'CONTACT SUPPORT.',
                };
                $statusTextColor = in_array($order->status, ['expired', 'cancelled']) ? 'color: white;' : '';
            @endphp

            <section class="brutal-card" style="background: {{ $statusBg }}; {{ $statusTextColor }}">
                <h2 style="font-size: 2.5rem; margin-bottom: 10px;">
                    STATUS: {{ $statusLabel }}
                </h2>
                @if ($order->status === 'pending')
                    <div id="countdown-container">
                        <p style="font-weight: 900; margin-bottom: 20px;">COMPLETE PAYMENT BEFORE VOID EXPIRES:</p>
                        <div id="countdown" style="font-size: 3rem; font-weight: 900; border: 4px solid black; background: white; color: black; padding: 10px 20px; display: inline-block;">
                            15:00
                        </div>
                    </div>
                @endif
                <p style="font-weight: 900; margin-top: 15px;">{{ $statusMsg }}</p>

                @if (in_array($order->status, ['expired', 'cancelled']))
                    <a href="{{ route('products') }}" class="brutal-button"
                        style="display: inline-block; margin-top: 20px; background: white; color: black; text-decoration: none;">
                        RE-INITIATE_ORDER
                    </a>
                @endif
            </section>

            {{-- Order Manifest --}}
            <section class="brutal-card">
                <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">MANIFEST_DETAILS</h2>
                <div style="display: grid; gap: 15px;">
                    @foreach ($order->items as $item)
                        <div class="flex-between" style="border-bottom: 2px solid rgba(0,0,0,0.1); padding-bottom: 10px;">
                            <div style="font-weight: 900;">
                                {{ strtoupper($item->product->name) }}
                                @if ($item->size)
                                    <span style="font-size: 0.75rem; opacity: 0.6;">[{{ $item->size->name }}]</span>
                                @endif
                                <span style="font-size: 0.75rem; opacity: 0.6;">x{{ $item->quantity }}</span>
                            </div>
                            <div style="font-weight: 900;">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex-between" style="padding-top: 15px; border-top: 4px solid black; margin-top: 10px;">
                    <h2 style="margin: 0;">TOTAL_VALUE:</h2>
                    <h2 style="margin: 0;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
                </div>
            </section>

            {{-- Shipping Info --}}
            <section class="brutal-card" style="background: var(--gallery-white);">
                <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">DISPATCH_POINT</h2>
                @if ($order->address)
                    <div style="font-weight: 900; font-size: 1.2rem; margin-bottom: 5px;">
                        {{ strtoupper($order->address->recipient_name) }}
                    </div>
                    <div style="font-weight: 700; opacity: 0.7; margin-bottom: 10px;">
                        SECTOR: {{ $order->address->street }}, {{ $order->address->city }}, {{ $order->address->postal_code }}
                    </div>
                    <div style="font-weight: 700; opacity: 0.7; margin-bottom: 5px;">
                        PHONE: {{ $order->address->phone }}
                    </div>
                @else
                    <div style="font-weight: 900; opacity: 0.5;">[NO_ADDRESS_DATA]</div>
                @endif
                <div style="font-weight: 700; opacity: 0.7; margin-top: 10px;">
                    METHOD: {{ strtoupper($order->payment_method) }}
                    @if ($order->bank)
                        ({{ strtoupper($order->bank) }})
                    @endif
                </div>
            </section>

        </div>

        {{-- Sidebar Actions --}}
        <div class="grid" style="gap: 20px; position: sticky; top: 100px;">

            @if ($order->status === 'pending')
                <form id="simulate-form" action="{{ route('order.simulate', $order->order_code) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="button"
                        onclick="window.BrutalModal.confirm('SIMULATE_SUCCESS?', 'THIS WILL MARK THE TRANSACTION AS PAID.', () => document.getElementById('simulate-form').submit(), 'SIMULATE', 'CANCEL')"
                        class="brutal-button"
                        style="width: 100%; background: var(--neon-green); font-size: 1.2rem;">
                        SIMULATE_PAYMENT_SUCCESS
                    </button>
                </form>

                <form id="cancel-form" action="{{ route('order.cancel', $order->order_code) }}" method="POST">
                    @csrf
                    @method('PATCH')
                </form>
                <button type="button"
                    onclick="window.BrutalModal.confirm(
                        'CANCEL_ORDER?',
                        'THIS WILL VOID THE TRANSACTION PERMANENTLY.',
                        () => document.getElementById('cancel-form').submit(),
                        'YES_CANCEL',
                        'ABORT'
                    )"
                    class="brutal-button"
                    style="width: 100%; background: #FF0000; color: white; font-size: 1.2rem;">
                    CANCEL_TRANSACTION
                </button>
            @endif

            @if (!in_array($order->status, ['expired', 'cancelled']))
                <a href="{{ route('products') }}" class="brutal-button"
                    style="width: 100%; text-align: center; text-decoration: none; display: block; background: var(--accent-pink); font-size: 1.2rem;">
                    BACK_TO_VAULT
                </a>
            @endif

            <a href="{{ route('profile') }}" class="brutal-button"
                style="width: 100%; text-align: center; text-decoration: none; display: block; background: white; font-size: 1.2rem;">
                VIEW_PROFILE
            </a>

            <div class="brutal-card" style="background: var(--brutal-black); color: white; margin-top: 20px;">
                <h3 style="font-size: 1.2rem; margin-bottom: 10px;">[NOTICE]</h3>
                <p style="font-size: 0.8rem; font-weight: 700; opacity: 0.7;">DO NOT SHARE TRANSACTION IDS WITH EXTERNAL NODES.</p>
            </div>
        </div>
    </div>
</div>

@if ($order->status === 'pending')
<script>
    const createdAt = new Date("{{ $order->created_at->toISOString() }}").getTime();
    const expiresAt = createdAt + (15 * 60 * 1000);
    const orderId   = "{{ $order->order_code }}";

    const timer = setInterval(() => {
        const now      = new Date().getTime();
        const distance = expiresAt - now;

        if (distance < 0) {
            clearInterval(timer);

            const countdownEl = document.getElementById('countdown');
            if (countdownEl) {
                countdownEl.innerHTML = 'EXPIRED';
                countdownEl.style.color = 'red';
            }

            fetch(`/order/${orderId}/expire`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            }).then(() => {
                setTimeout(() => location.reload(), 1500);
            });

            return;
        }

        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('countdown').innerHTML =
            (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    }, 1000);
</script>
@endif

@endsection