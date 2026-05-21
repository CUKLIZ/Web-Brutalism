@extends('layout')

@section('content')
<section class="container" style="padding: 60px 0; background: #D9D9D9; min-height: 100vh;">
    <div class="grid" style="grid-template-columns: 1fr 450px; gap: 40px; align-items: start;">
        
        <!-- LEFT SIDE -->
        <div style="display: flex; flex-direction: column; gap: 40px;">
            <div style="position: relative;">
                <div style="position: absolute; top: -10px; left: -10px; width: 40px; height: 40px; border-top: 4px solid black; border-left: 4px solid black; z-index: 5;"></div>
                <div class="offset-box" style="width: 100%;">
                    <div style="border: 4px solid black; background: #000; position: relative; line-height: 0;">
                        @php
                            $mainImage = $product->images->first()->image_path ?? null;
                            $mainImageSrc = $mainImage
                                ? (str_starts_with($mainImage, 'http') ? $mainImage : asset('storage/' . $mainImage))
                                : 'https://placehold.co/800x600/000/fff?text=NO_IMAGE';
                        @endphp
                        <img src="{{ $mainImageSrc }}" alt="{{ $product->name }}" style="width: 100%; border: 4px solid black; filter: contrast(110%);">
                        <div style="position: absolute; bottom: 40px; right: 0; background: var(--neon-green); border: 4px solid black; padding: 10px 30px; transform: translateX(20px);">
                            <h2 style="font-size: 3rem; line-height: 1; margin: 0; font-weight: 900;">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 30px;">
                @foreach($product->images->slice(1, 2) as $image)
                    @php
                        $imgSrc = str_starts_with($image->image_path, 'http')
                            ? $image->image_path
                            : asset('storage/' . $image->image_path);
                    @endphp
                    <div style="border: 4px solid black; background: #000; line-height: 0;">
                        <img src="{{ $imgSrc }}" style="width: 100%; filter: grayscale(100%) contrast(150%);">
                    </div>
                @endforeach
                @if($product->images->count() < 3)
                    <div style="border: 4px solid black; background: #000; line-height: 0;">
                        <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80" style="width: 100%; filter: grayscale(100%) contrast(150%);">
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div style="position: sticky; top: 120px;">
            <div class="flex" style="gap: 10px; margin-bottom: 20px;">
                <span style="background: black; color: white; padding: 4px 12px; font-weight: 900; font-size: 0.7rem; border: 2px solid black;">LIMITED_EDITION</span>
                <span style="background: var(--neon-green); color: black; padding: 4px 12px; font-weight: 900; font-size: 0.7rem; border: 2px solid black;">NEW_DROP</span>
                <span style="background: var(--accent-pink); color: white; padding: 4px 12px; font-weight: 900; font-size: 0.7rem; border: 2px solid black;">LOW_STOCK</span>
            </div>

            <div style="margin-bottom: 30px;">
                <p class="brutal-font" style="font-size: 0.8rem; margin-bottom: 5px; opacity: 0.6;">CYBER_CORE</p>
                <h1 style="font-size: 3.5rem; line-height: 1; font-weight: 900; letter-spacing: -2px; margin: 0;">{!! str_replace(' ', '<br>', $product->name) !!}</h1>
            </div>

            <!-- SPECIFICATIONS PANEL -->
            <div style="border: 4px solid black; background: white; margin-bottom: 30px; position: relative; box-shadow: 8px 8px 0px black;">
                <div style="position: absolute; top: -15px; right: 20px; background: black; color: white; padding: 2px 10px; font-size: 0.6rem; font-weight: 900; border: 2px solid black;">DATASHEET_V1.0</div>
                <div style="padding: 20px; border-bottom: 2px solid black; display: flex; gap: 20px;">
                    <div style="width: 4px; background: #0000FF;"></div>
                    <p style="font-weight: 900; font-size: 0.9rem; line-height: 1.2; text-transform: uppercase;">
                        HEAVYWEIGHT 500GSM FLEECE. OVERSIZED BOX CUT. REINFORCED STITCHING FOR URBAN DESTRUCTION. GLOW-IN-DARK PRINTED GRAPHICS.
                    </p>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="padding: 10px; border-right: 2px solid black; border-bottom: 2px solid black; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_CONTENT</span><br>100% C-TECH COTTON
                    </div>
                    <div style="padding: 10px; border-bottom: 2px solid black; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_WEIGHT</span><br>1.2KG // HEAVY
                    </div>
                    <div style="padding: 10px; border-right: 2px solid black; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_FIT</span><br>VOID_RELAXED_CUT
                    </div>
                    <div style="padding: 10px; font-size: 0.6rem; font-weight: 900;">
                        <span style="opacity: 0.4;">_COLOUR</span><br>DISTRICT_GR_LII8
                    </div>
                </div>
            </div>

            <!-- SIZE SELECTOR + ADD TO CART FORM -->
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size_id" id="selected_size_id" value="">

                <div style="margin-bottom: 30px;">
                    <div class="flex-between" style="border-bottom: 4px solid black; padding-bottom: 5px; margin-bottom: 15px;">
                        <p style="font-weight: 900; font-style: italic; font-size: 1.2rem;">SELECT_SIZE</p>
                        <a href="#" style="font-size: 0.6rem; color: #888; font-weight: 900;">SIZE_GUIDE.PDF</a>
                    </div>
                    <div class="flex" style="gap: 10px; flex-wrap: wrap;">
                        @foreach($product->sizes as $size)
                            @php $outOfStock = $size->pivot->stock === 0; @endphp
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                <button 
                                    type="button"
                                    onclick="{{ !$outOfStock ? 'selectSize(this, ' . $size->id . ', ' . $size->pivot->stock . ')' : '' }}"
                                    class="brutal-button size-btn"
                                    style="width: 50px; height: 50px; padding: 0; font-size: 1rem; display: flex; align-items: center; justify-content: center;
                                        background: {{ $outOfStock ? '#ccc' : 'white' }};
                                        color: {{ $outOfStock ? '#999' : 'black' }};
                                        cursor: {{ $outOfStock ? 'not-allowed' : 'pointer' }};
                                        text-decoration: {{ $outOfStock ? 'line-through' : 'none' }};"
                                    {{ $outOfStock ? 'disabled' : '' }}>
                                    {{ $size->name }}
                                </button>
                                <span style="font-size: 0.55rem; font-weight: 900; color: {{ $outOfStock ? '#999' : ($size->pivot->stock <= 3 ? 'red' : '#333') }};">
                                    {{ $outOfStock ? 'OUT' : $size->pivot->stock . '_LEFT' }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    @if(session('success'))
                        <p style="margin-top: 15px; font-weight: 900; font-size: 0.8rem; color: green;">{{ session('success') }}</p>
                    @endif
                </div>

                <!-- QTY SELECTOR -->
                <div id="qty-section" style="display: none; margin-bottom: 30px; border: 4px solid black; padding: 15px; background: white; box-shadow: 6px 6px 0px black;">
                    <div class="flex-between" style="margin-bottom: 10px;">
                        <p style="font-weight: 900; font-size: 0.8rem;">SELECT_QTY</p>
                        <p id="stock-label" style="font-weight: 900; font-size: 0.8rem; color: #0000FF;"></p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0; border: 4px solid black;">
                        <button type="button" onclick="changeQty(-1)"
                            style="width: 50px; height: 50px; background: black; color: white; font-size: 1.5rem; font-weight: 900; border: none; cursor: pointer; flex-shrink: 0;">−</button>
                        <input type="number" name="quantity" id="qty-input" value="1" min="1" readonly
                            style="flex: 1; height: 50px; border: none; border-left: 4px solid black; border-right: 4px solid black; text-align: center; font-family: inherit; font-weight: 900; font-size: 1.2rem; background: #f0f0f0; outline: none;">
                        <button type="button" onclick="changeQty(1)"
                            style="width: 50px; height: 50px; background: black; color: white; font-size: 1.5rem; font-weight: 900; border: none; cursor: pointer; flex-shrink: 0;">+</button>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    @auth
                        <button type="submit" id="add-to-cart-btn"
                                style="background: var(--neon-green); color: black; font-size: 2.5rem; width: 100%; padding: 25px 30px; font-weight: 900; border: 4px solid black; box-shadow: 8px 8px 0px black; cursor: pointer; display: flex; align-items: center; justify-content: space-between; opacity: 0.5;"
                                disabled>
                            <span style="font-style: italic;">ADD_TO_BAG</span>
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="square" stroke-linejoin="miter"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                           style="background: var(--neon-green); color: black; font-size: 2.5rem; width: 100%; padding: 25px 30px; font-weight: 900; border: 4px solid black; box-shadow: 8px 8px 0px black; display: flex; align-items: center; justify-content: space-between; text-decoration: none;">
                            <span style="font-style: italic;">LOGIN_TO_BUY</span>
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="square" stroke-linejoin="miter"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        </a>
                    @endauth
                    <button type="button" class="brutal-button" style="background: #E5E5E5; color: black; font-size: 1.2rem; width: 100%; padding: 15px 0; font-style: italic;">
                        INSTANT_BUY_CMD
                    </button>
                </div>
            </form>
            
            <p style="margin-top: 30px; font-size: 0.6rem; font-weight: 900; opacity: 0.6; line-height: 1.5;">
                [CRITICAL_WARNING]: ALL TRANSACTIONS ARE FINAL. THE VOID DOES NOT ISSUE REFUNDS. TRACKING DATA WILL BE SENT TO YOUR REGISTERED TERMINAL WITHIN 48H.
            </p>
        </div>
    </div>
</section>

@php
    $reviews     = $product->reviews()->with('user')->latest()->get();
    $avgRating   = $reviews->avg('rating') ?? 0;
    $totalReviews = $reviews->count();
    $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    foreach ($reviews as $r) $distribution[$r->rating]++;

    // Cek apakah user login & sudah beli produk ini
    $canReview      = false;
    $alreadyReviewed = false;

    if (Auth::check()) {
        $hasBought = \App\Models\Order::where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'completed'])
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->exists();

        $alreadyReviewed = \App\Models\Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        $canReview = $hasBought && !$alreadyReviewed;
    }
@endphp

<section class="container" style="padding: 100px 20px; background: #eee; border-top: 8px solid black;">

    {{-- HEADER --}}
    <div style="margin-bottom: 60px;">
        <div style="background: black; color: white; display: inline-block; padding: 2px 12px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ COMMUNITY_FEEDBACK ]</div>
        <h2 style="font-size: 4rem; font-weight: 900; line-height: 0.8; letter-spacing: -3px; margin: 0; text-transform: uppercase;">REVIEWS_AND_LOGS</h2>
    </div>

    {{-- FLASH MESSAGES --}}
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

    <div class="grid" style="grid-template-columns: 350px 1fr; gap: 60px; align-items: start;">

        {{-- LEFT: STATS + FORM --}}
        <div style="position: sticky; top: 120px; display: grid; gap: 30px;">

            {{-- RATING STATS --}}
            <div class="brutal-card" style="background: white; padding: 30px; border: 4px solid black; box-shadow: 10px 10px 0px black;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="font-size: 5.5rem; font-weight: 900; line-height: 1;">{{ number_format($avgRating, 1) }}</div>
                    <div style="font-size: 1.5rem; margin-top: 10px;">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= round($avgRating) ? '★' : '☆' }}
                        @endfor
                    </div>
                    <div style="font-size: 0.7rem; font-weight: 900; opacity: 0.5; margin-top: 5px;">BASED_ON_{{ $totalReviews }}_SIGNALS</div>
                </div>

                <div style="display: grid; gap: 10px;">
                    @foreach ([5,4,3,2,1] as $star)
                        @php $pct = $totalReviews > 0 ? round(($distribution[$star] / $totalReviews) * 100) : 0; @endphp
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 0.7rem; font-weight: 900; width: 45px;">{{ $star }}_STAR</span>
                            <div style="flex: 1; height: 12px; background: #eee; border: 2px solid black; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: 0; left: 0; height: 100%; background: var(--neon-green); width: {{ $pct }}%;"></div>
                            </div>
                            <span style="font-size: 0.6rem; font-weight: 900; width: 35px;">{{ $pct }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- REQUIREMENT INFO --}}
            <div class="brutal-card" style="background: black; color: white; padding: 20px; border: 4px solid black; box-shadow: 10px 10px 0px var(--neon-green);">
                <h3 style="font-size: 0.8rem; margin-bottom: 15px; background: var(--neon-green); color: black; display: inline-block; padding: 2px 10px; font-weight: 900;">[REQUIREMENT]</h3>
                <p style="font-size: 0.75rem; font-weight: 900; opacity: 0.8; line-height: 1.6;">
                    ONLY VERIFIED PURCHASERS WHO HAVE COMPLETED THE TRANSACTION CYCLE CAN TRANSMIT DATA TO THIS ARCHIVE.
                </p>
            </div>

            {{-- REVIEW FORM --}}
            @auth
                @if ($canReview)
                    <div style="border: 4px solid black; background: white; padding: 25px; box-shadow: 8px 8px 0px black;">
                        <div style="background: black; color: var(--neon-green); display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ SUBMIT_REVIEW ]</div>

                        <form action="{{ route('review.store', $product->id) }}" method="POST">
                            @csrf

                            {{-- STAR RATING --}}
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; font-weight: 900; font-size: 0.75rem; margin-bottom: 10px;">SIGNAL_STRENGTH (RATING)</label>
                                <div style="display: flex; gap: 8px;" id="star-container">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" onclick="setRating({{ $i }})"
                                            id="star-{{ $i }}"
                                            style="width: 44px; height: 44px; border: 3px solid black; background: white; font-size: 1.4rem; cursor: pointer; transition: all 0.1s; font-family: inherit;">
                                            ☆
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-input" value="">
                                @error('rating')
                                    <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- REVIEW TEXT --}}
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; font-weight: 900; font-size: 0.75rem; margin-bottom: 8px;">TRANSMISSION_BODY</label>
                                <textarea name="body" placeholder="DESCRIBE YOUR EXPERIENCE WITH THIS ITEM..."
                                    style="width: 100%; border: 3px solid {{ $errors->has('body') ? 'red' : 'black' }}; padding: 12px; font-family: inherit; font-weight: 900; outline: none; min-height: 120px; resize: none; font-size: 0.9rem;">{{ old('body') }}</textarea>
                                @error('body')
                                    <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="brutal-button" style="width: 100%; background: black; color: var(--neon-green); padding: 15px 0; font-size: 1rem;">
                                TRANSMIT_REVIEW
                            </button>
                        </form>
                    </div>
                @elseif ($alreadyReviewed)
                    <div style="border: 4px solid var(--neon-green); background: white; padding: 20px; font-weight: 900; font-size: 0.85rem;">
                        ✓ YOU_HAVE_ALREADY_REVIEWED_THIS_PRODUCT
                    </div>
                @else
                    <div style="border: 4px dashed black; background: white; padding: 20px; font-weight: 900; font-size: 0.8rem; opacity: 0.6; text-align: center;">
                        [PURCHASE_REQUIRED_TO_REVIEW]
                    </div>
                @endif
            @else
                <div style="border: 4px dashed black; background: white; padding: 20px; font-weight: 900; font-size: 0.8rem; text-align: center;">
                    <a href="{{ route('login') }}" style="color: black; text-decoration: underline;">LOGIN</a> TO SUBMIT A REVIEW
                </div>
            @endauth
        </div>

        {{-- RIGHT: REVIEWS LIST --}}
        <div>
            @forelse ($reviews as $review)
                <div class="brutal-card" style="background: white; padding: 40px; border: 4px solid black; box-shadow: 12px 12px 0px black; margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 40px; height: 40px; border: 3px solid black; flex-shrink: 0; overflow: hidden;">
                                @if($review->user->avatar)
                                    <img src="{{ asset('storage/' . $review->user->avatar) }}"
                                        style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                @else
                                    <div style="width: 100%; height: 100%; background: black; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 950;">
                                        {{ strtoupper(substr($review->user->username, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <span style="font-weight: 950; font-size: 1.2rem; text-transform: uppercase; display: block; line-height: 1;">{{ strtoupper($review->user->username) }}</span>
                                <span style="font-size: 0.6rem; font-weight: 900; opacity: 0.4; margin-top: 5px; display: block;">TIMESTAMP: {{ $review->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 1.5rem; line-height: 1; margin-bottom: 8px;">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </div>
                            <span style="background: var(--neon-green); color: black; padding: 2px 10px; font-size: 0.6rem; font-weight: 950; border: 2px solid black; display: inline-block;">VERIFIED_PURCHASE</span>
                        </div>
                    </div>
                    <div style="border-top: 4px solid black; padding-top: 25px;">
                        <p style="font-weight: 900; font-size: 1.1rem; line-height: 1.4; margin: 0; font-style: italic;">"{{ $review->body }}"</p>
                    </div>
                </div>
            @empty
                <div style="padding: 100px 40px; text-align: center; border: 6px dashed black; background: white;">
                    <h2 style="font-weight: 950; font-size: 3rem; margin-bottom: 10px; opacity: 0.1;">NO_SIGNAL_FROM_THE_CULT_YET</h2>
                    <p style="font-weight: 900; font-size: 0.8rem; opacity: 0.4;">BE_THE_FIRST_TO_INFILTRATE_THIS_ARCHIVE.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    function setRating(value) {
        document.getElementById('rating-input').value = value;
        for (let i = 1; i <= 5; i++) {
            const btn = document.getElementById('star-' + i);
            if (i <= value) {
                btn.innerText = '★';
                btn.style.background = 'var(--neon-green)';
            } else {
                btn.innerText = '☆';
                btn.style.background = 'white';
            }
        }
    }
</script>

<script>
let maxStock = 1;

function selectSize(el, sizeId, stock) {
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.style.background = 'white';
        btn.style.color = 'black';
    });

    el.style.background = 'black';
    el.style.color = 'white';

    document.getElementById('selected_size_id').value = sizeId;

    maxStock = stock;
    document.getElementById('stock-label').textContent = stock <= 3 
        ? 'CRITICAL_STOCK: ' + stock + '_UNITS' 
        : 'STOCK: ' + stock + '_UNITS';
    document.getElementById('stock-label').style.color = stock <= 3 ? 'red' : '#0000FF';

    const qtyInput = document.getElementById('qty-input');
    qtyInput.value = 1;
    qtyInput.max = stock;

    document.getElementById('qty-section').style.display = 'block';

    const btn = document.getElementById('add-to-cart-btn');
    if (btn) {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
}

function changeQty(delta) {
    const input = document.getElementById('qty-input');
    const current = parseInt(input.value);
    const next = current + delta;
    if (next >= 1 && next <= maxStock) {
        input.value = next;
    }
}
</script>

@endsection