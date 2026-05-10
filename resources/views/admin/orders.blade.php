@extends('admin.layout')

@section('content')

<div style="margin-bottom: 40px; position: relative;">
    <div style="position: absolute; top: -30px; left: 0; font-size: 0.55rem; font-weight: 900; color: #888;">[STATUS: ONLINE] [SYNC: OK] [ENCRYPTION: ACTIVE]</div>
    <div class="flex" style="align-items: flex-end; gap: 15px;">
        <h1 style="font-size: 4rem; font-weight: 900; line-height: 0.8; letter-spacing: -3px; margin: 0;">TRANSACTION_LOG</h1>
        <div style="width: 120px; height: 8px; background: #000; margin-bottom: 6px;"></div>
    </div>
    <p class="brutal-font" style="font-size: 1.1rem; background: #000; color: var(--neon-green); display: inline-block; padding: 6px 15px; margin-top: 20px; font-weight: 900; transform: skewX(-10deg);">
        [TOTAL: {{ $orders->total() }}_RECORDS_FOUND]
    </p>
</div>

{{-- FILTER & SEARCH --}}
<form method="GET" action="{{ route('admin.orders') }}"
      style="display: grid; grid-template-columns: 1fr auto auto; gap: 15px; align-items: end; margin-bottom: 40px;">

    {{-- Search --}}
    <div>
        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[SEARCH_QUERY]</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="ORDER_ID / USERNAME"
               style="width: 100%; border: 4px solid black; padding: 12px 20px; font-weight: 900; outline: none; background: #fff; font-family: inherit; font-size: 0.9rem;">
    </div>

    {{-- Status Filter --}}
    <div>
        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[STATUS_FILTER]</label>
        <select name="status"
                style="border: 4px solid black; padding: 12px 20px; font-weight: 900; outline: none; background: #fff; font-family: inherit; font-size: 0.9rem; appearance: none; cursor: pointer; min-width: 180px;">
            <option value="">ALL_STATUS</option>
            @foreach (['pending', 'paid', 'completed', 'expired'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                    {{ strtoupper($s) }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="brutal-button"
            style="background: black; color: var(--neon-green); padding: 12px 30px; font-size: 1rem; height: fit-content;">
        EXECUTE_FILTER
    </button>
</form>

{{-- ORDERS TABLE --}}
<div style="border: 4px solid #000; overflow: hidden; margin-bottom: 40px;">
    <table style="width: 100%; border-collapse: collapse; font-weight: 900;">
        <thead>
            <tr style="background: #000; color: var(--neon-green); font-size: 0.7rem;">
                <th style="padding: 14px 15px; text-align: left;">ORDER_ID</th>
                <th style="padding: 14px 15px; text-align: left;">USER</th>
                <th style="padding: 14px 15px; text-align: left;">ITEMS</th>
                <th style="padding: 14px 15px; text-align: left;">TOTAL</th>
                <th style="padding: 14px 15px; text-align: left;">PAYMENT</th>
                <th style="padding: 14px 15px; text-align: left;">STATUS</th>
                <th style="padding: 14px 15px; text-align: left;">DATE</th>
                <th style="padding: 14px 15px; text-align: left;">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                @php
                    $statusColor = match($order->status) {
                        'paid'      => 'var(--neon-green)',
                        'completed' => '#00ff88',
                        'pending'   => 'var(--accent-yellow)',
                        'expired'   => '#FF0000',
                        default     => '#ccc',
                    };
                    $statusTextColor = in_array($order->status, ['expired']) ? 'color: #fff;' : 'color: #000;';
                @endphp
                <tr style="border-bottom: 2px solid #000; font-size: 0.8rem; {{ $loop->even ? 'background: #f5f5f5;' : 'background: #fff;' }}">
                    <td style="padding: 12px 15px; font-size: 0.75rem; font-family: monospace; font-weight: 900;">
                        {{ $order->order_code ?? '#' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td style="padding: 12px 15px;">
                        {{ strtoupper($order->user->username ?? 'N/A') }}
                    </td>
                    <td style="padding: 12px 15px; font-size: 0.75rem; opacity: 0.7;">
                        {{ $order->items->count() }}_ITEM(S)
                    </td>
                    <td style="padding: 12px 15px;">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td style="padding: 12px 15px; font-size: 0.75rem; opacity: 0.7;">
                        {{ strtoupper($order->payment_method ?? '-') }}
                        @if ($order->bank)
                            <span style="opacity: 0.6;">({{ strtoupper($order->bank) }})</span>
                        @endif
                    </td>
                    <td style="padding: 12px 15px;">
                        <span style="background: {{ $statusColor }}; {{ $statusTextColor }} padding: 3px 10px; font-size: 0.65rem; border: 2px solid #000; display: inline-block;">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td style="padding: 12px 15px; opacity: 0.6; font-size: 0.7rem;">
                        {{ $order->created_at->format('Y-m-d') }}<br>
                        <span style="opacity: 0.7;">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td style="padding: 12px 15px;">
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            {{-- Mark as Completed --}}
                            @if ($order->status === 'paid')
                                <form id="complete-form-{{ $order->id }}" action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                    </form>
                                    <button type="button"
                                        onclick="window.BrutalModal.confirm(
                                            'MARK_AS_COMPLETE?',
                                            'ORDER {{ $order->order_code }} WILL BE MARKED AS COMPLETED. THIS ACTION CANNOT BE UNDONE.',
                                            () => document.getElementById('complete-form-{{ $order->id }}').submit(),
                                            'CONFIRM_COMPLETE',
                                            'CANCEL'
                                        )"
                                        style="background: var(--neon-green); border: 2px solid black; padding: 4px 10px; font-weight: 900; font-size: 0.6rem; cursor: pointer; white-space: nowrap;">
                                        MARK_COMPLETE
                                    </button>
                            @endif

                            {{-- View Detail --}}
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               style="background: black; color: white; border: 2px solid black; padding: 4px 10px; font-weight: 900; font-size: 0.6rem; text-decoration: none; white-space: nowrap;">
                                VIEW
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 60px; text-align: center; opacity: 0.5; font-weight: 900;">
                        [NO_TRANSACTIONS_FOUND]
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
@if ($orders->hasPages())
    <div style="display: flex; gap: 10px; align-items: center; justify-content: center;">
        @if ($orders->onFirstPage())
            <span style="border: 3px solid #ccc; padding: 8px 16px; font-weight: 900; opacity: 0.4;">&laquo; PREV</span>
        @else
            <a href="{{ $orders->previousPageUrl() }}"
               style="border: 3px solid black; padding: 8px 16px; font-weight: 900; text-decoration: none; color: black; box-shadow: 3px 3px 0px black;">
                &laquo; PREV
            </a>
        @endif

        <span style="font-weight: 900; font-size: 0.8rem; padding: 8px 16px; background: black; color: var(--neon-green);">
            PAGE {{ $orders->currentPage() }} / {{ $orders->lastPage() }}
        </span>

        @if ($orders->hasMorePages())
            <a href="{{ $orders->nextPageUrl() }}"
               style="border: 3px solid black; padding: 8px 16px; font-weight: 900; text-decoration: none; color: black; box-shadow: 3px 3px 0px black;">
                NEXT &raquo;
            </a>
        @else
            <span style="border: 3px solid #ccc; padding: 8px 16px; font-weight: 900; opacity: 0.4;">NEXT &raquo;</span>
        @endif
    </div>
@endif

@endsection