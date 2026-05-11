@extends('layout')

@section('content')
<section class="container" style="padding: 60px 0;">
    <div class="flex-between" style="align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
        <h1 style="font-size: 5rem; background: var(--accent-yellow); display: inline-block; padding: 0 20px; line-height: 1;">ALL LOOT</h1>
        
        <div class="brutal-font" style="font-size: 1.2rem; font-weight: 900;">
            [{{ count($products) }}_RESULTS_FOUND]
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div style="margin-bottom: 60px;">
        <form action="/products" method="GET" id="filter-form" class="grid" style="grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
            <div class="flex" style="flex-direction: column; gap: 15px;">
                <div class="offset-box" style="width: 100%;">
                    <input type="text" name="q" id="search-input" value="{{ $searchQuery }}" placeholder="SEARCH_THE_VAULT..." 
                           class="brutal-border brutal-font" 
                           style="width: 100%; padding: 15px; font-size: 1.2rem; background: var(--gallery-white); outline: none;">
                </div>
                
                <div class="flex" style="gap: 10px; flex-wrap: wrap;">
                    @foreach($categories as $cat)
                        <button type="button" 
                                class="brutal-button category-btn {{ $activeCategory === $cat ? 'active' : '' }}" 
                                data-category="{{ $cat }}"
                                style="padding: 5px 15px; font-size: 0.9rem; {{ $activeCategory === $cat ? 'background: var(--neon-green); transform: translate(4px, 4px); box-shadow: none;' : '' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                    <input type="hidden" name="category" id="category-input" value="{{ $activeCategory }}">
                </div>
            </div>
            <button type="submit" class="brutal-button" style="height: 60px; padding: 0 40px; font-size: 1.5rem; background: var(--brutal-black); color: var(--neon-green);">
                SEARCH
            </button>
        </form>
    </div>
    
    @if(count($products) === 0)
        <div class="brutal-card" style="padding: 100px 20px; text-align: center; background: #eee;">
            <h2 style="font-size: 3rem;">NO_LOOT_FOUND</h2>
            <p class="brutal-font" style="margin-top: 20px;">TRY ADJUSTING YOUR SEARCH OR FILTERS TO UNLOCK THE VAULT.</p>
            <a href="/products" class="brutal-button" style="margin-top: 40px; display: inline-block;">RESET_ALL</a>
        </div>
    @else
        <div class="grid product-grid" id="product-list">
            @foreach($products as $product)
                <x-product-card :product="$product" :useDataAttrs="true" className="product-item" />
            @endforeach
        </div>
        
        <div id="no-results-msg" class="brutal-card" style="padding: 100px 20px; text-align: center; background: #eee; display: none;">
            <h2 style="font-size: 3rem;">NO_MATCHING_LOOT</h2>
            <p class="brutal-font" style="margin-top: 20px;">SEARCH_TERM_NOT_FOUND_IN_VAULT.</p>
        </div>
    @endif

    <!-- Quick View Modal -->
    <div id="quick-view-modal" class="modal-overlay">
        <div class="modal-content">
            <button id="close-modal" class="close-modal">X</button>
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
                <div style="border: 4px solid black; background: black;">
                    <img id="modal-image" src="" alt="" style="width: 100%; display: block;">
                </div>
                <div>
                    <span id="modal-category" class="badge" style="background: var(--neon-green); color: black;">CATEGORY</span>
                    <h2 id="modal-name" style="font-size: 2rem; margin: 15px 0; line-height: 1.1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">PRODUCT_NAME</h2>
                    <p id="modal-price" class="brutal-font" style="font-size: 2.5rem; margin-bottom: 20px;">Rp 0</p>
                    <div style="border: 2px solid black; padding: 15px; background: #f0f0f0; margin-bottom: 20px;">
                        <p class="brutal-font" style="font-size: 0.8rem; line-height: 1.5;">
                            [SYSTEM_DESCRIPTION]: THIS ARCHIVE PIECE HAS BEEN EXTRACTED FROM THE DIGITAL VOID. HEAVYWEIGHT CONSTRUCTION WITH EXPERIMENTAL FINISHING.
                        </p>
                    </div>
                    <a id="modal-link" href="#" class="brutal-button" style="width: 100%; text-align: center; display: block; background: black; color: white;">VIEW_FULL_INTEL</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Initialize filtering state from server-provided variables
    window.INITIAL_CATEGORY = "{{ $activeCategory }}";
    window.INITIAL_SEARCH = "{{ $searchQuery }}";
</script>
@endsection
