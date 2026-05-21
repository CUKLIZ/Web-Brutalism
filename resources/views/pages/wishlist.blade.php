@extends('layout')

@section('content')
<section class="container" style="padding: 60px 0; background: #D9D9D9; min-height: 100vh;">
    <div style="margin-bottom: 60px; border-bottom: 6px solid black; padding-bottom: 20px;">
        <h1 style="font-size: 7rem; line-height: 0.8; font-style: italic; font-weight: 1000; letter-spacing: -4px; margin: 0; text-transform: uppercase; text-shadow: 6px 6px 0px var(--brutal-black);">SAVED_VAULT</h1>
        <p class="brutal-font" style="font-size: 1.8rem; font-weight: 900; margin-top: 15px;">[0{{ $wishlists->count() }}_ASSETS_LINKED_TO_YOUR_VAULT]</p>
    </div>

    @if($wishlists->isEmpty())
        <div style="position: relative; overflow: hidden; background: white; border: 8px solid black; padding: 120px 40px; text-align: center; box-shadow: 20px 20px 0px black; margin-top: 40px;">
            <div style="position: absolute; top: -20px; left: -20px; width: 100px; height: 100px; background: var(--accent-yellow); transform: rotate(-15deg); z-index: 0; border: 4px solid black;"></div>
            <div style="position: absolute; bottom: -10px; right: 50px; width: 150px; height: 60px; background: var(--neon-green); transform: rotate(5deg); z-index: 0; border: 4px solid black;"></div>
            <div style="position: relative; z-index: 1;">
                <h2 style="font-size: clamp(2.5rem, 8vw, 5rem); line-height: 0.9; margin-bottom: 20px; font-weight: 950; letter-spacing: -3px; text-transform: uppercase;">YOUR_WISHLIST_IS_EMPTY</h2>
                <p class="brutal-font" style="font-size: 1.2rem; margin-bottom: 40px; background: black; color: white; display: inline-block; padding: 5px 15px; text-transform: uppercase; font-weight: 900;">
                    [ SAVE PRODUCTS BEFORE THEY DISAPPEAR INTO THE VOID ]
                </p>
                <br>
                <a href="{{ route('products') }}" class="brutal-button" style="font-size: 2rem; background: var(--neon-green); padding: 20px 40px; text-decoration: none; display: inline-block;">RETRIEVE_ASSETS</a>
            </div>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 30px; max-width: 900px; margin: 0 auto;">
            @foreach($wishlists as $index => $wishlist)
                @php
                    $product = $wishlist->product;
                    $firstImage = $product->images->first()->image_path ?? null;
                    $imageSrc = $firstImage
                        ? (str_starts_with($firstImage, 'http') ? $firstImage : asset('storage/' . $firstImage))
                        : 'https://placehold.co/400x250/000/fff?text=NO_IMAGE';
                @endphp
                <div class="wishlist-item-card" id="wishlist-card-{{ $product->id }}">
                    <img src="{{ $imageSrc }}" alt="{{ $product->name }}" class="wishlist-item-img">

                    <div style="padding: 25px; display: flex; flex-direction: column; justify-content: center;">
                        <span style="background: black; color: var(--neon-green); padding: 2px 10px; font-weight: 900; font-size: 0.65rem; border: 2px solid black; display: inline-block; align-self: flex-start; margin-bottom: 12px; letter-spacing: 1px;">
                            [{{ $product->category }}]
                        </span>
                        <h2 style="font-size: 2.5rem; line-height: 1; font-weight: 1000; margin: 0; letter-spacing: -1px; text-transform: uppercase;">
                            {{ str_replace(' ', '_', $product->name) }}
                        </h2>
                        <div style="margin-top: 15px; display: flex; align-items: center; gap: 10px;">
                            <span style="font-weight: 900; font-size: 0.65rem; background: var(--neon-green); color: black; border: 2px solid black; padding: 2px 8px; letter-spacing: 1px;">
                                SECURE_IN_STOCK
                            </span>
                            <span style="font-weight: 900; font-size: 0.65rem; opacity: 0.5;">
                                V_STATUS: READY_TO_DEPLOY
                            </span>
                        </div>
                    </div>

                    <div style="padding: 25px; border-left: 6px solid black; display: flex; flex-direction: column; justify-content: space-between; gap: 15px; background: #fafafa;">
                        <div>
                            <span style="font-size: 0.65rem; font-weight: 900; opacity: 0.4; display: block;">ASSET_PRICE</span>
                            <h3 style="font-size: 2rem; font-weight: 950; margin: 5px 0 0 0; line-height: 1;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </h3>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <a href="{{ route('product.detail', [strtolower($product->category), $product->slug]) }}"
                                class="brutal-button"
                                style="background: var(--accent-pink); color: white; padding: 12px 10px; font-size: 0.85rem; width: 100%; border: 3px solid black; box-shadow: 4px 4px 0px black; text-align: center; text-decoration: none;">
                                VIEW_ASSET
                            </a>
                            <button onclick="toggleWishlist(this, {{ $product->id }})"
                                data-wishlisted="true"
                                data-card-id="wishlist-card-{{ $product->id }}"
                                class="brutal-button"
                                style="background: black; color: white; padding: 8px 10px; font-size: 0.7rem; width: 100%; border: 3px solid black; box-shadow: 4px 4px 0px black; text-align: center;">
                                REMOVE_X
                            </button>
                        </div>
                    </div>

                    <div style="position: absolute; right: 10px; top: 10px; font-family: monospace; font-size: 1.2rem; font-weight: 900; pointer-events: none; opacity: 0.05;">
                        VAULT_ID_{{ $product->id }}
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 60px;">
            <button type="button" onclick="confirmPurgeAll()" class="brutal-button" style="background: black; color: red; border-color: black; font-size: 1.2rem; padding: 15px 40px;">
                PURGE_ALL_VAULT_RECORDS
            </button>
        </div>

        <form id="purge-all-form" action="{{ route('wishlist.clear') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</section>

<style>
    .wishlist-item-card {
        display: grid;
        grid-template-columns: 180px 1fr 200px;
        background: white;
        border: 6px solid black;
        box-shadow: 12px 12px 0px black;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .wishlist-item-card:hover {
        transform: translate(-4px, -4px);
        box-shadow: 16px 16px 0px black;
    }
    .wishlist-item-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-right: 6px solid black;
    }
    @media (max-width: 768px) {
        .wishlist-item-card {
            grid-template-columns: 1fr;
        }
        .wishlist-item-img {
            height: 250px;
            border-right: none;
            border-bottom: 6px solid black;
        }
    }
</style>

<script>
    function confirmPurgeAll() {
        window.BrutalModal.confirm(
            'PURGE_COMPLETE_VAULT?',
            'THIS ACTION WILL PERMANENTLY REMOVE ALL SAVED RECORDS FROM YOUR VAULT. THIS CANNOT BE UNDONE.',
            () => {
                document.getElementById('purge-all-form').submit();
            },
            'PERFORM_PURGE',
            'ABORT_MISSION'
        );
    }
</script>
@endsection