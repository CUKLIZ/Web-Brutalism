@extends('layout')

@section('content')

<style>
    .loot-table tbody tr {
        transition: background-color 0.1s ease;
        cursor: pointer;
    }
    .loot-table tbody tr:hover {
        background-color: var(--accent-yellow) !important;
    }
    .address-card-header {
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .address-card-header:hover {
        background: rgba(0,0,0,0.05);
    }
    .address-details {
        max-height: 1000px;
        overflow: hidden;
        transition: max-height 0.3s ease, margin-top 0.3s ease, opacity 0.3s ease;
    }
    .address-details.collapsed {
        max-height: 0;
        margin-top: 0 !important;
        opacity: 0;
        pointer-events: none;
    }
</style>

<div class="container" style="padding-top: 60px; padding-bottom: 100px;">
    <div style="margin-bottom: 60px;">
        <h1 style="font-size: 5rem; line-height: 0.9; margin-bottom: 20px; text-shadow: 6px 6px 0px var(--brutal-black);">USER_PROFILE</h1>
        <div style="background: var(--accent-pink); border: 4px solid black; padding: 10px 20px; display: inline-block; font-weight: 900; box-shadow: 6px 6px 0px black;">
            [STATUS: AUTHENTICATED]
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div style="background: var(--neon-green); border: 4px solid black; padding: 15px 20px; font-weight: 900; margin-bottom: 30px; box-shadow: 4px 4px 0px black;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background: #FF0000; color: white; border: 4px solid black; padding: 15px 20px; font-weight: 900; margin-bottom: 30px; box-shadow: 4px 4px 0px black;">
            ✗ {{ session('error') }}
        </div>
    @endif

    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;">
        {{-- Left Side: User Info --}}
        <div class="grid" style="gap: 40px;">
            {{-- Section 00: AVATAR UPLOAD --}}
            <section class="brutal-card" style="background: var(--neon-green); display: flex; align-items: center; gap: 30px;">
                <div style="width: 120px; height: 120px; border: 4px solid black; background: white; flex-shrink: 0; display: flex; justify-content: center; align-items: center; box-shadow: 4px 4px 0px black; overflow: hidden;">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span style="font-weight: 900; font-size: 0.7rem; text-align: center;">[NO_IMAGE_DATA]</span>
                    @endif
                </div>
                <div style="flex-grow: 1;">
                    <h2 style="font-size: 1.5rem; border-bottom: 4px solid black; padding-bottom: 5px; margin-bottom: 15px;">00_IDENTITY_VISUAL</h2>
                    <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 10px;">
                        @csrf
                        @method('PATCH')
                        <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display: none;" onchange="this.form.submit()">
                        <label for="avatar-input" class="brutal-button" style="display: block; width: 100%; text-align: center; font-size: 0.8rem; cursor: pointer; padding: 10px;">SELECT_LOCAL_FILE</label>
                        <button type="submit" class="brutal-button" style="background: black; color: white; width: 100%; font-size: 0.8rem; padding: 10px;">TRIGGER_UPLOAD</button>
                    </form>
                </div>
            </section>

            {{-- Section 01: USER INFO --}}
            <section class="brutal-card" style="background: var(--accent-yellow);">
                <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">01_PERSONAL_DATA</h2>
                <div style="display: grid; gap: 15px;">
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">ID_TAG</span>
                        <span class="brutal-font" style="font-size: 1.5rem;">{{ Auth::user()->username }}</span>
                    </div>
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">COMM_CHANNEL</span>
                        <span class="brutal-font" style="font-size: 1.5rem;">{{ Auth::user()->email }}</span>
                    </div>
                    <div>
                        <span style="display: block; font-weight: 900; font-size: 0.8rem; color: rgba(0,0,0,0.6);">CLEARANCE_LEVEL</span>
                        <span style="background: black; color: var(--neon-green); padding: 4px 12px; font-weight: 900; font-size: 1rem; border: 2px solid black; display: inline-block; margin-top: 5px;">
                            {{ strtoupper(Auth::user()->role ?? 'CUSTOMER') }}
                        </span>
                    </div>
                </div>
            </section>
        </div>

        {{-- Right Side: Transaction History --}}
        <div class="grid">
            {{-- Section 03: TRANSACTION HISTORY --}}
            <section class="brutal-card" style="padding: 0; overflow: hidden;">
                <div style="background: var(--brutal-black); color: white; padding: 20px;">
                    <h2 style="font-size: 2rem;">03_TRANSACTION_LOG</h2>
                    <p style="font-size: 0.8rem; font-weight: 900; margin-top: 5px; opacity: 0.7;">CLICK ROW TO VIEW DETAIL — RECENT DATA ENTRIES IN VAULT HISTORY</p>
                </div>
                <div style="padding: 20px; overflow-x: auto;">
                    <table class="loot-table" style="margin: 0; border: none; width: 100%;">
                        <thead>
                            <tr>
                                <th style="border-left: none; border-top: none; font-size: 0.7rem; padding: 10px;">ORDER_ID</th>
                                <th style="font-size: 0.7rem; padding: 10px;">TOTAL</th>
                                <th style="font-size: 0.7rem; padding: 10px;">STATUS</th>
                                <th style="border-right: none; border-top: none; font-size: 0.7rem; padding: 10px;">DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                @php
                                    $isLast = $loop->last;
                                    $statusColors = [
                                        'completed' => 'var(--neon-green)',
                                        'paid'      => 'var(--accent-yellow)',
                                        'pending'   => 'var(--accent-pink)',
                                        'cancelled' => '#FF0000',
                                    ];
                                    $statusColor = $statusColors[strtolower($order->status)] ?? '#ccc';
                                    // $statusTextColor = strtolower($order->status) === 'pending' ? 'white' : 'black';
                                    $statusTextColor = in_array(strtolower($order->status), ['pending', 'cancelled']) ? 'white' : 'black';
                                    $rowUrl = $order->status === 'pending'
                                        ? route('order.success', $order->order_code)
                                        : route('order.detail', $order->order_code);
                                @endphp
                                <tr onclick="window.location='{{ $rowUrl }}'" title="VIEW_DETAIL">
                                    <td style="border-left: none; {{ $isLast ? 'border-bottom: none;' : '' }} font-family: monospace; font-weight: 900;">
                                        {{ $order->order_code }}
                                    </td>
                                    <td class="brutal-font" style="{{ $isLast ? 'border-bottom: none;' : '' }}">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td style="{{ $isLast ? 'border-bottom: none;' : '' }}">
                                        <span class="badge" style="background: {{ $statusColor }}; color: {{ $statusTextColor }};">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>
                                    <td style="border-right: none; {{ $isLast ? 'border-bottom: none;' : '' }} font-size: 0.8rem; font-weight: 700;">
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="border: none; text-align: center; padding: 30px; font-weight: 900; opacity: 0.5;">
                                        [NO_TRANSACTION_DATA]
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    {{-- SIDE-BY-SIDE SECTION (FULL WIDTH ROW) --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(450px, 100%), 1fr)); gap: 40px; align-items: start; margin-top: 40px;">

        {{-- Section 02: EDIT PROFILE FORM --}}
        <section class="brutal-card">
            <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">02_UPDATE_PROFILE</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="display: grid; gap: 20px;">
                    <div style="display: grid; gap: 8px;">
                        <label class="brutal-font" style="font-size: 1rem;">USERNAME</label>
                        <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                            style="width: 100%; border: 4px solid {{ $errors->has('username') ? 'red' : 'black' }}; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                        @error('username')
                            <span style="color: red; font-weight: 900; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label class="brutal-font" style="font-size: 1rem;">EMAIL_ADDRESS</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                            style="width: 100%; border: 4px solid {{ $errors->has('email') ? 'red' : 'black' }}; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                        @error('email')
                            <span style="color: red; font-weight: 900; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label class="brutal-font" style="font-size: 1rem;">NEW_PASSWORD (KOSONGKAN JIKA TIDAK DIUBAH)</label>
                        <input type="password" name="password" placeholder="********"
                            style="width: 100%; border: 4px solid {{ $errors->has('password') ? 'red' : 'black' }}; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                        @error('password')
                            <span style="color: red; font-weight: 900; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label class="brutal-font" style="font-size: 1rem;">CONFIRM_PASSWORD</label>
                        <input type="password" name="password_confirmation" placeholder="********"
                            style="width: 100%; border: 4px solid black; padding: 15px; font-family: inherit; font-weight: 900; outline: none;">
                    </div>
                    <button type="submit" class="brutal-button" style="width: 100%; margin-top: 10px;">SAVE_CHANGES</button>
                </div>
            </form>
        </section>

        {{-- Section 04: ADDRESS BOOK --}}
        <section class="brutal-card" style="background: var(--gallery-white);">
            <h2 style="font-size: 2rem; border-bottom: 4px solid black; padding-bottom: 10px; margin-bottom: 20px;">04_ADDRESS_BOOK</h2>

            {{-- Address List --}}
            <div style="display: grid; gap: 20px; margin-bottom: 40px;">
                @forelse ($addresses as $address)
                    @php $isDefault = $address->is_default; @endphp
                    <div class="address-card" style="border: 4px solid {{ $isDefault ? 'var(--neon-green)' : 'black' }}; padding: 20px; background: white; position: relative;">
                        @if ($isDefault)
                            <div style="position: absolute; top: -15px; right: 10px; background: var(--neon-green); border: 2px solid black; padding: 2px 10px; font-weight: 900; font-size: 0.6rem; box-shadow: 2px 2px 0px black;">DEFAULT_LOCATION</div>
                        @endif
                        <div class="address-card-header" onclick="toggleAddress(this)">
                            <div style="font-weight: 900; font-size: 1.2rem;">{{ strtoupper(str_replace(' ', '_', $address->label ?? $address->recipient_name)) }}</div>
                            <div style="font-weight: 900; font-size: 1.2rem;">[+/-]</div>
                        </div>
                        <div class="address-details">
                            <div style="font-weight: 700; opacity: 0.7; margin-top: 10px; margin-bottom: 5px;">{{ $address->phone }}</div>
                            <div style="font-weight: 500; line-height: 1.4;">{{ $address->street }}, {{ $address->city }}, {{ $address->postal_code }}</div>
                            <div style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;">
                                @if ($isDefault)
                                    <button style="border: 2px solid black; background: var(--neon-green); color: black; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: default;">[IS_DEFAULT]</button>
                                @else
                                    <form action="{{ route('profile.address.default', $address->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="border: 2px solid black; background: white; color: black; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer;">SET_AS_DEFAULT</button>
                                    </form>
                                @endif
                                <a href="{{ route('profile.address.edit', $address->id) }}" style="border: 2px solid black; background: black; color: white; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer; text-decoration: none;">EDIT</a>
                                <form id="delete-address-{{ $address->id }}" 
                                        action="{{ route('profile.address.destroy', $address->id) }}" 
                                        method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button onclick="window.BrutalModal.confirm(
                                    'DELETE_ADDRESS?', 
                                    'THIS ACTION CANNOT BE UNDONE.', 
                                    () => document.getElementById('delete-address-{{ $address->id }}').submit(), 
                                    'DELETE', 
                                    'CANCEL'
                                )" style="border: 2px solid black; background: #FF0000; color: white; padding: 5px 12px; font-weight: 900; font-size: 0.7rem; cursor: pointer;">DELETE</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="border: 4px dashed black; padding: 30px; text-align: center; font-weight: 900; opacity: 0.5;">
                        [NO_ADDRESS_DATA]
                    </div>
                @endforelse
            </div>

            {{-- Add Address Form --}}
            <div style="border: 4px solid black; background: var(--accent-pink); padding: 25px;">
                <h3 style="font-size: 1.2rem; font-weight: 900; margin-bottom: 20px;">[+]_NEW_DISPATCH_LOCATION</h3>
                <form action="{{ route('profile.address.store') }}" method="POST">
                    @csrf
                    <div style="display: grid; gap: 15px;">
                        <div style="display: grid; gap: 5px;">
                            <label style="font-weight: 900; font-size: 0.8rem;">FULL_NAME</label>
                            <input type="text" name="recipient_name" placeholder="RECIPIENT_NAME" value="{{ old('recipient_name') }}"
                                style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                            @error('recipient_name')
                                <span style="color: darkred; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div style="display: grid; gap: 5px;">
                            <label style="font-weight: 900; font-size: 0.8rem;">PHONE_NUMBER</label>
                            <input type="text" name="phone" placeholder="+62 ..." value="{{ old('phone') }}"
                                style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                            @error('phone')
                                <span style="color: darkred; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div style="display: grid; gap: 5px;">
                            <label style="font-weight: 900; font-size: 0.8rem;">STREET_ADDRESS</label>
                            <textarea name="street" placeholder="FULL_ADDRESS_DETAILS"
                                style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none; min-height: 80px; resize: vertical;">{{ old('street') }}</textarea>
                            @error('street')
                                <span style="color: darkred; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div style="display: grid; gap: 5px;">
                                <label style="font-weight: 900; font-size: 0.8rem;">CITY</label>
                                <input type="text" name="city" placeholder="METROPOLIS" value="{{ old('city') }}"
                                    style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                                @error('city')
                                    <span style="color: darkred; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="display: grid; gap: 5px;">
                                <label style="font-weight: 900; font-size: 0.8rem;">POSTAL_CODE</label>
                                <input type="text" name="postal_code" placeholder="XXXXX" value="{{ old('postal_code') }}"
                                    style="width: 100%; border: 3px solid black; padding: 10px; font-family: inherit; font-weight: 900; outline: none;">
                                @error('postal_code')
                                    <span style="color: darkred; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="brutal-button" style="width: 100%; margin-top: 10px; background: black; color: white;">ADD_ADDRESS</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    {{-- Section 05: DANGER ZONE --}}
    <div style="margin-top: 40px;">
        <section class="brutal-card" style="background: var(--brutal-black); color: white;">
            <h2 style="font-size: 2rem; border-bottom: 4px solid var(--gallery-white); padding-bottom: 10px; margin-bottom: 20px;">05_DANGER_ZONE</h2>
            <p style="margin-bottom: 20px; font-weight: 700; opacity: 0.8;">DISCONNECT FROM SYSTEM VAULT TEMPORARILY.</p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="brutal-button" style="background: #FF0000; color: white; width: 100%; border-color: white;">ABORT_SESSION_(LOGOUT)</button>
            </form>
        </section>
    </div>
</div>

<script>
    function toggleAddress(header) {
        const details = header.nextElementSibling;
        details.classList.toggle('collapsed');
    }
</script>

@endsection