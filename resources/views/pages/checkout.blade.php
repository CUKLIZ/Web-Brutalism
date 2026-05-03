@extends('layout')

@section('content')

<section class="container" style="padding: 60px 0;">
    <h1 style="font-size: 5rem; margin-bottom: 40px; text-align: center;">CHECKOUT_PAYMENT</h1>

    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 40px;">

        <div class="brutal-card">
            <h2 style="margin-bottom: 30px;">SECURE_TRANSACTION</h2>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                {{-- FULL NAME --}}
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">USERNAME</label>
                    <input type="text" name="full_name" class="brutal-border" readonly
                        style="width: 100%; padding: 15px; font-size: 1.2rem; font-family: inherit; font-weight: 900; outline: none;"
                        placeholder="JOHN_DOE_EXAMPLE"
                        value="{{ old('full_name', Auth::user()->username) }}">
                    @error('full_name')
                        <span style="color: red; font-weight: 900; font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- SELECT ADDRESS --}}
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">SELECT ADDRESS</label>
                    <select name="address_id" class="brutal-border"
                        style="width: 100%; padding: 15px; font-size: 1rem; font-family: inherit; font-weight: 900; background: white; appearance: none; cursor: pointer; outline: none;">
                        <option value="">-- SELECT_LOCATION --</option>
                        @forelse ($addresses as $address)
                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                                {{ strtoupper($address->recipient_name) }} - {{ $address->street }}, {{ $address->city }}
                            </option>
                        @empty
                            <option value="" disabled>[NO_ADDRESS — ADD IN PROFILE]</option>
                        @endforelse
                    </select>
                    @error('address_id')
                        <span style="color: red; font-weight: 900; font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- PAYMENT METHOD --}}
                <div style="margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">PAYMENT METHOD</label>
                    <select name="payment_method" id="payment_method" class="brutal-border"
                        style="width: 100%; padding: 15px; font-size: 1.2rem; font-family: inherit; font-weight: 900; background: white; appearance: none; cursor: pointer; outline: none;">
                        <option value="">-- SELECT_PAYMENT --</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="qris">QRIS</option>
                        <option value="dana">DANA</option>
                        <option value="ovo">OVO</option>
                        <option value="gopay">GoPay</option>
                    </select>
                    @error('payment_method')
                        <span style="color: red; font-weight: 900; font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- CONDITIONAL: Bank Selection --}}
                <div id="bank_selection" style="display: none; margin-bottom: 20px;">
                    <label class="brutal-font" style="display: block; margin-bottom: 10px;">SELECT BANK</label>
                    <select name="bank" class="brutal-border"
                        style="width: 100%; padding: 15px; font-size: 1.2rem; font-family: inherit; font-weight: 900; background: white; appearance: none; cursor: pointer; outline: none;">
                        <option value="bca">BCA</option>
                        <option value="bri">BRI</option>
                        <option value="mandiri">Mandiri</option>
                        <option value="bni">BNI</option>
                    </select>
                </div>

                {{-- CONDITIONAL: QRIS --}}
                <div id="qris_placeholder" style="display: none; margin-bottom: 20px;">
                    <div class="brutal-border" style="width: 100%; height: 200px; background: #fff; display: flex; align-items: center; justify-content: center;">
                        <span style="font-weight: 900; opacity: 0.5;">[QR_CODE_PLACEHOLDER]</span>
                    </div>
                </div>

                {{-- CONDITIONAL: Redirect msg --}}
                <div id="redirect_msg" style="display: none; margin-bottom: 20px;">
                    <p style="font-weight: 900; font-size: 0.9rem; color: var(--brutal-black);">"You will be redirected after payment"</p>
                </div>

                <button type="submit" class="brutal-button" style="width: 100%; font-size: 2rem; background: var(--accent-pink); margin-top: 20px;">PAY NOW</button>
            </form>
        </div>

        {{-- RIGHT: ORDER MANIFEST --}}
        <div class="brutal-card" style="height: fit-content; background: #e0e0e0;">
            <h3 style="margin-bottom: 20px;">MANIFEST</h3>

            @forelse ($cartItems as $item)
                <div class="flex-between" style="margin-bottom: 10px;">
                    <span style="font-weight: 700;">{{ strtoupper($item->product->name) }}
                        @if($item->size)
                            <span style="font-size: 0.75rem; opacity: 0.6;">[{{ $item->size->name }}]</span>
                        @endif
                        <span style="font-size: 0.75rem; opacity: 0.6;">x{{ $item->quantity }}</span>
                    </span>
                    <span class="brutal-font">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                </div>
            @empty
                <p style="font-weight: 900; opacity: 0.5; text-align: center;">[CART_EMPTY]</p>
            @endforelse

            <hr style="border: 2px solid black; margin: 20px 0;">

            <div class="flex-between" style="margin-bottom: 10px;">
                <span style="font-weight: 700;">SUBTOTAL</span>
                <span class="brutal-font">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex-between" style="margin-bottom: 10px;">
                <span style="font-weight: 700;">SHIPPING</span>
                <span class="brutal-font" style="{{ $shipping == 0 ? 'color: var(--neon-green);' : '' }}">
                    {{ $shipping == 0 ? 'FREE' : 'Rp ' . number_format($shipping, 0, ',', '.') }}
                </span>
            </div>

            <hr style="border: 2px solid black; margin: 20px 0;">

            <div class="flex-between">
                <h2 style="margin: 0;">TOTAL:</h2>
                <h2 style="margin: 0;">Rp {{ number_format($total, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('payment_method').addEventListener('change', function () {
        const method = this.value;
        document.getElementById('bank_selection').style.display   = method === 'bank_transfer' ? 'block' : 'none';
        document.getElementById('qris_placeholder').style.display = method === 'qris' ? 'block' : 'none';
        document.getElementById('redirect_msg').style.display     = ['dana', 'ovo', 'gopay'].includes(method) ? 'block' : 'none';
    });
</script>

@endsection