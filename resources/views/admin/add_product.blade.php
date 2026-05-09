@extends('admin.layout')

@section('content')

<div style="margin-bottom: 40px;">
    <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px;">ADD_NEW_ITEM</h1>
</div>

<div class="admin-stat-card" style="max-width: 700px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf

        <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[PRODUCT_NAME]</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="VOID_ITEM_NULL"
                       style="width: 100%; border: 3px solid {{ $errors->has('name') ? 'red' : 'black' }}; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0; font-size: 0.9rem;">
                @error('name')
                    <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[PRICE_IDR]</label>
                <input type="number" name="price" value="{{ old('price') }}" placeholder="0"
                       style="width: 100%; border: 3px solid {{ $errors->has('price') ? 'red' : 'black' }}; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0; font-size: 0.9rem;">
                @error('price')
                    <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[CATEGORY]</label>
            <select name="category" style="width: 100%; border: 3px solid {{ $errors->has('category') ? 'red' : 'black' }}; padding: 12px; font-family: inherit; font-weight: 900; outline: none; background: #f0f0f0; font-size: 0.9rem;">
                @foreach (['T-SHIRT', 'OUTERWEAR', 'PANTS', 'ACCESSORIES', 'SHOES'] as $cat)
                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')
                <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 6px;">[SIZE_STOCK_MATRIX]</label>
            <div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px;">
                @foreach (['S', 'M', 'L', 'XL'] as $size)
                    <div>
                        <input type="number" name="stock[{{ $size }}]" value="{{ old('stock.' . $size, 0) }}" placeholder="{{ $size }}"
                               style="width: 100%; border: 2px solid black; padding: 8px; font-weight: 900; font-size: 0.8rem; font-family: inherit; outline: none;">
                        <span style="font-size: 0.65rem; font-weight: 900; display: block; text-align: center; margin-top: 3px;">{{ $size }}</span>
                    </div>
                @endforeach
            </div>
            @error('stock')
                <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label style="display: block; font-weight: 900; font-size: 0.7rem; margin-bottom: 12px;">[IMAGE_SOURCE_CONTROL]</label>
            <div class="grid" style="grid-template-columns: 1.4fr 1fr; grid-template-rows: 150px 150px; gap: 15px;">

                {{-- Main Image --}}
                <div style="grid-row: span 2; border: 4px solid {{ $errors->has('image') ? 'red' : 'black' }}; padding: 15px; text-align: center; background: #fff; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[IMAGE_01_PRIMARY]</div>
                    <div style="border: 2px dashed #999; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px;">
                        <img id="img-preview-1" src="" style="max-width: 100%; max-height: 100px; display: none; object-fit: contain; margin-bottom: 10px; border: 2px solid black;">
                        <p id="label-1" style="font-weight: 900; opacity: 0.5; font-size: 0.7rem; line-height: 1.4;">UPLOAD_RAW_IMAGE<br>OR DROP_FILE</p>
                        <input type="file" name="image" accept="image/*" onchange="previewImage(event, 1)" style="margin-top: 15px; font-size: 0.7rem; width: 100%;">
                    </div>
                    @error('image')
                        <span style="color: red; font-weight: 900; font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Image 02 --}}
                <div style="border: 4px solid black; padding: 12px; text-align: center; background: #f0f0f0; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[IMAGE_02]</div>
                    <div style="border: 2px dashed #bbb; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <img id="img-preview-2" src="" style="max-width: 100%; max-height: 50px; display: none; object-fit: contain; margin-bottom: 5px; border: 1px solid black;">
                        <p id="label-2" style="font-weight: 900; opacity: 0.5; font-size: 0.6rem;">ALT_VIEW_01</p>
                        <input type="file" name="image_2" accept="image/*" onchange="previewImage(event, 2)" style="margin-top: 10px; font-size: 0.65rem; width: 100%;">
                    </div>
                </div>

                {{-- Image 03 --}}
                <div style="border: 4px solid black; padding: 12px; text-align: center; background: #f0f0f0; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.55rem; font-weight: 900; z-index: 5;">[IMAGE_03]</div>
                    <div style="border: 2px dashed #bbb; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <img id="img-preview-3" src="" style="max-width: 100%; max-height: 50px; display: none; object-fit: contain; margin-bottom: 5px; border: 1px solid black;">
                        <p id="label-3" style="font-weight: 900; opacity: 0.5; font-size: 0.6rem;">ALT_VIEW_02</p>
                        <input type="file" name="image_3" accept="image/*" onchange="previewImage(event, 3)" style="margin-top: 10px; font-size: 0.65rem; width: 100%;">
                    </div>
                </div>
            </div>
        </div>

        <button type="button" onclick="confirmSave()" class="brutal-button"
                style="width: 100%; background: var(--neon-green); color: black; font-size: 1.5rem; padding: 20px 0; font-weight: 900; margin-top: 15px;">
            SAVE_PRODUCT_TO_VAULT
        </button>
    </form>
</div>

<script>
    function previewImage(event, id) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('img-preview-' + id);
            const label = document.getElementById('label-' + id);
            output.src = reader.result;
            output.style.display = 'block';
            label.style.display = 'none';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function confirmSave() {
        const name = document.querySelector('input[name="name"]').value || 'UNNAMED';
        window.BrutalModal.confirm(
            'SAVE_TO_VAULT?',
            `CONFIRM ADDING [${name.toUpperCase()}] TO THE PRODUCT DATABASE.`,
            () => document.querySelector('form').submit(),
            'CONFIRM_SAVE',
            'CANCEL_OPS'
        );
    }
</script>

@endsection