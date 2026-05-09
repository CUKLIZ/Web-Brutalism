@extends('admin.layout')

@section('content')

<div style="margin-bottom: 40px;">
    <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px;">EDIT_PRODUCT_INTEL</h1>
    <p class="brutal-font" style="font-size: 1rem; background: #000; color: var(--neon-green); display: inline-block; padding: 4px 12px; margin-top: 15px; font-weight: 900;">
        [EDIT_MODE_ACTIVE] // ID: #{{ $product->id }}
    </p>
</div>

{{-- Flash Messages --}}
@if (session('success'))
    <div style="background: var(--neon-green); border: 4px solid black; padding: 15px 20px; font-weight: 900; margin-bottom: 30px; box-shadow: 4px 4px 0px black;">
        ✓ {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background: #FF0000; color: white; border: 4px solid black; padding: 15px 20px; font-weight: 900; margin-bottom: 30px; box-shadow: 4px 4px 0px black;">
        @foreach ($errors->all() as $error)
            <div>✗ {{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="{{ route('admin.products.update', $product->id) }}" method="POST"
      enctype="multipart/form-data"
      style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">
    @csrf
    @method('PUT')

    <div style="display: grid; gap: 30px;">

        {{-- PRODUCT_INFO --}}
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ PRODUCT_INFO ]</div>

            <div style="display: grid; gap: 20px;">
                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 8px;">PRODUCT_NAME</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                           style="width: 100%; border: 4px solid {{ $errors->has('name') ? 'red' : 'black' }}; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 1.1rem; box-shadow: 4px 4px 0px black;">
                    @error('name')
                        <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">CATEGORY</label>
                        <select name="category" style="width: 100%; border: 4px solid {{ $errors->has('category') ? 'red' : 'black' }}; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem; appearance: none; cursor: pointer;">
                            @foreach (['T-SHIRT', 'OUTERWEAR', 'PANTS', 'ACCESSORIES', 'SHOES'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">PRICE_POINT (IDR)</label>
                        <input type="number" name="price" id="price-input" value="{{ old('price', $product->price) }}"
                               style="width: 100%; border: 4px solid {{ $errors->has('price') ? 'red' : 'black' }}; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: var(--neon-green); color: black; font-size: 1.1rem; box-shadow: 4px 4px 0px black;">
                        @error('price')
                            <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 8px;">DESCRIPTION</label>
                    <textarea name="description"
                              style="width: 100%; border: 4px solid {{ $errors->has('description') ? 'red' : 'black' }}; padding: 15px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 1rem; min-height: 120px; resize: none;">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- PRODUCT_SPECS --}}
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ PRODUCT_SPECS ]</div>

            <div style="display: grid; gap: 20px;">
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">WEIGHT (G)</label>
                        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" placeholder="400" min="0"
                               style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">FIT</label>
                        <input type="text" name="fit" value="{{ old('fit', $product->fit) }}" placeholder="VOID_RELAXED_CUT"
                               style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">COLOUR</label>
                        <input type="text" name="colour" value="{{ old('colour', $product->colour) }}" placeholder="DISTRICT_GR_LI18"
                               style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 8px;">CONTENT / MATERIAL</label>
                        <input type="text" name="content" value="{{ old('content', $product->content) }}" placeholder="100% C-TECH COTTON"
                               style="width: 100%; border: 3px solid black; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: white; font-size: 0.9rem;">
                    </div>
                </div>
            </div>
        </div>

        {{-- INVENTORY --}}
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ INVENTORY ]</div>

            <div>
                <label style="display: block; font-weight: 900; font-size: 0.8rem; margin-bottom: 12px;">STOCK_BY_SIZE</label>
                <div class="grid" style="grid-template-columns: repeat({{ $product->sizes->count() ?: 4 }}, 1fr); gap: 10px;">
                    @forelse ($product->sizes as $size)
                        <div>
                            <span style="font-size: 0.6rem; font-weight: 900; display: block; margin-bottom: 4px;">{{ $size->name }}</span>
                            <input type="number" name="sizes[{{ $size->id }}]"
                                   value="{{ old('sizes.' . $size->id, $size->pivot->stock) }}"
                                   min="0"
                                   style="width: 100%; border: 3px solid black; padding: 10px; font-weight: 900; outline: none; font-family: inherit;">
                        </div>
                    @empty
                        {{-- Fallback ke all sizes kalau product belum punya sizes --}}
                        @foreach ($sizes as $size)
                            <div>
                                <span style="font-size: 0.6rem; font-weight: 900; display: block; margin-bottom: 4px;">{{ $size->name }}</span>
                                <input type="number" name="sizes[{{ $size->id }}]"
                                       value="{{ old('sizes.' . $size->id, 0) }}"
                                       min="0"
                                       style="width: 100%; border: 3px solid black; padding: 10px; font-weight: 900; outline: none; font-family: inherit;">
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div style="display: grid; gap: 30px; position: sticky; top: 30px;">

        {{-- ASSET VAULT --}}
        <div class="admin-stat-card">
            <div style="background: black; color: white; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ ASSET_VAULT ]</div>

            @php $images = $product->images->take(3)->pad(3, null); @endphp

            <div style="display: grid; gap: 15px;">
                {{-- Primary Image --}}
                <div style="border: 4px solid black; padding: 15px; text-align: center; background: #fff; position: relative; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[PRIMARY_ASSET]</div>
                    <div style="border: 2px dashed #999; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px;">
                        <img id="img-preview-1"
                             src="{{ $images[0] ? asset('storage/' . $images[0]->image_path) : '' }}"
                             style="max-width: 100%; max-height: 100%; {{ $images[0] ? 'display: block;' : 'display: none;' }} object-fit: contain; border: 2px solid black;">
                        <p id="label-1" style="font-weight: 900; opacity: 0.5; font-size: 0.7rem; line-height: 1.4; {{ $images[0] ? 'display: none;' : '' }}">DROP_MASTER_FILE</p>
                        <input type="file" name="images[0]" accept="image/*" onchange="previewImage(event, 1)" style="margin-top: 15px; font-size: 0.7rem; width: 100%;">
                        @if ($images[0])
                            <input type="hidden" name="existing_images[0]" value="{{ $images[0]->id }}">
                        @endif
                    </div>
                </div>

                {{-- Alt Images --}}
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div style="border: 3px solid black; padding: 10px; text-align: center; background: #f0f0f0; position: relative; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                        <div style="border: 2px dashed #bbb; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <img id="img-preview-2"
                                 src="{{ $images[1] ? asset('storage/' . $images[1]->image_path) : '' }}"
                                 style="max-width: 100%; max-height: 100%; {{ $images[1] ? 'display: block;' : 'display: none;' }} object-fit: contain; border: 1px solid black;">
                            <p id="label-2" style="font-weight: 900; opacity: 0.5; font-size: 0.55rem;">ALT_V_01</p>
                            <input type="file" name="images[1]" accept="image/*" onchange="previewImage(event, 2)" style="margin-top: 8px; font-size: 0.5rem; width: 100%;">
                            @if ($images[1])
                                <input type="hidden" name="existing_images[1]" value="{{ $images[1]->id }}">
                            @endif
                        </div>
                    </div>
                    <div style="border: 3px solid black; padding: 10px; text-align: center; background: #f0f0f0; position: relative; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                        <div style="border: 2px dashed #bbb; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <img id="img-preview-3"
                                 src="{{ $images[2] ? asset('storage/' . $images[2]->image_path) : '' }}"
                                 style="max-width: 100%; max-height: 100%; {{ $images[2] ? 'display: block;' : 'display: none;' }} object-fit: contain; border: 1px solid black;">
                            <p id="label-3" style="font-weight: 900; opacity: 0.5; font-size: 0.55rem;">ALT_V_02</p>
                            <input type="file" name="images[2]" accept="image/*" onchange="previewImage(event, 3)" style="margin-top: 8px; font-size: 0.5rem; width: 100%;">
                            @if ($images[2])
                                <input type="hidden" name="existing_images[2]" value="{{ $images[2]->id }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PREVIEW CARD --}}
        <div class="admin-stat-card" style="background: #000; color: #fff;">
            <div style="background: var(--neon-green); color: #000; display: inline-block; padding: 2px 10px; font-weight: 900; font-size: 0.7rem; margin-bottom: 20px;">[ PREVIEW_OUTPUT ]</div>

            <div style="border: 3px solid white; padding: 15px; background: #111;">
                <div style="aspect-ratio: 1/1; background: #222; margin-bottom: 15px; border: 2px solid white; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img id="preview-card-img"
                         src="{{ $images[0] ? asset('storage/' . $images[0]->image_path) : '' }}"
                         style="width: 100%; height: 100%; object-fit: cover; {{ $images[0] ? 'display: block;' : 'display: none;' }}">
                    <span id="preview-card-placeholder" style="font-size: 0.6rem; color: #444; font-weight: 900; {{ $images[0] ? 'display: none;' : '' }}">[NO_IMAGE_SOURCE]</span>
                </div>
                <h3 id="preview-card-name" style="font-size: 1.2rem; font-weight: 900; margin-bottom: 5px; text-transform: uppercase;">{{ $product->name }}</h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span id="preview-card-price" style="color: var(--neon-green); font-weight: 900; font-size: 1.1rem;">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span style="background: white; color: black; padding: 2px 6px; font-size: 0.6rem; font-weight: 900;">STS: LIVE</span>
                </div>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div style="display: grid; gap: 10px;">
            <button type="button" onclick="confirmUpdate()" class="brutal-button"
                    style="width: 100%; background: var(--neon-green); color: black; font-size: 1.5rem; padding: 25px 0; font-weight: 900; border-color: black; box-shadow: 6px 6px 0px black;">
                SYNC_UPDATE_TO_VAULT
            </button>
            <a href="{{ route('admin.products.index') }}" class="brutal-button"
               style="text-align: center; background: white; color: black; text-decoration: none; padding: 15px 0; font-weight: 900; font-size: 0.9rem; border-color: black; display: block;">
                ABORT_MISSION_(CANCEL)
            </a>
        </div>
    </div>
</form>

<script>
    function previewImage(event, id) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('img-preview-' + id);
            const label  = document.getElementById('label-' + id);
            output.src   = reader.result;
            output.style.display = 'block';
            if (label) label.style.display = 'none';

            if (id === 1) {
                const cardImg         = document.getElementById('preview-card-img');
                const cardPlaceholder = document.getElementById('preview-card-placeholder');
                cardImg.src           = reader.result;
                cardImg.style.display = 'block';
                if (cardPlaceholder) cardPlaceholder.style.display = 'none';
            }
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function confirmUpdate() {
        const name = document.querySelector('input[name="name"]').value || 'UNNAMED';
        window.BrutalModal.confirm(
            'SYNC_UPDATE?',
            `CONFIRM UPDATING [${name.toUpperCase()}] IN THE PRODUCT DATABASE.`,
            () => document.querySelector('form').submit(),
            'CONFIRM_SYNC',
            'CANCEL_OPS'
        );
    }

    // Live preview
    document.addEventListener('DOMContentLoaded', () => {
        const nameInput  = document.querySelector('input[name="name"]');
        const priceInput = document.getElementById('price-input');
        const cardName   = document.getElementById('preview-card-name');
        const cardPrice  = document.getElementById('preview-card-price');

        nameInput?.addEventListener('input', (e) => {
            cardName.innerText = e.target.value.toUpperCase() || 'VOID_ITEM';
        });

        priceInput?.addEventListener('input', (e) => {
            const val = parseInt(e.target.value) || 0;
            cardPrice.innerText = 'IDR ' + val.toLocaleString('id-ID');
        });
    });
</script>

@endsection