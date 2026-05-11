@extends('layout')

@section('content')
<section class="hero-banner-wrap" style="border-bottom: 10px solid var(--brutal-black); background: var(--brutal-black); overflow: hidden;">
    <div style="position: relative; height: 75vh; min-height: 500px; width: 100%;">
        <img src="{{ asset('images/hero.jpg') }}" 
             onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=2000&auto=format&fit=crop'"
             alt="System Hero v1" 
             style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; filter: grayscale(1) contrast(1.2);">
        
        <!-- Brutalist Overlay Elements -->
        <div style="position: absolute; bottom: -4px; left: -4px; background: var(--neon-green); border: var(--border-width) solid var(--brutal-black); padding: 25px 50px; z-index: 10; box-shadow: 10px -10px 0px var(--brutal-black);">
            <p class="brutal-font" style="font-size: 1.5rem; color: var(--brutal-black); letter-spacing: 4px; margin: 0;">[SYSTEM_UPDATE_2024]</p>
        </div>

        <div style="position: absolute; top: 10%; right: 5%; background: var(--accent-yellow); border: var(--border-width) solid var(--brutal-black); padding: 30px; box-shadow: 15px 15px 0px var(--brutal-black); z-index: 10; transform: rotate(-3deg);">
            <h2 style="font-size: 4rem; color: var(--brutal-black); line-height: 1;">NEW<br>VOID<br>GEAR</h2>
        </div>
        
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 20px solid rgba(0,0,0,0.1); pointer-events: none; z-index: 5;"></div>
    </div>
</section>

<section class="hero">
    <div class="layered-block" style="top: 10%; left: 5%; width: 200px; height: 200px; transform: rotate(-5deg);"></div>
    <div class="layered-block" style="bottom: 15%; left: 40%; width: 150px; height: 150px; transform: rotate(10deg); background: var(--accent-yellow);"></div>
    
    <div class="container hero-content">
        <h1>LOOT<br>VAULT</h1>
        <div class="offset-box">
            <p class="brutal-font" style="font-size: 1.5rem; max-width: 500px; margin-bottom: 0; background: var(--gallery-white); padding: 20px; border: var(--border-width) solid var(--brutal-black);">
                EXPERIMENTAL GEAR FOR THE DIGITAL VOID. NO REFUNDS. NO MERCY.
            </p>
        </div>
        <div style="margin-top: 60px;">
            <a href="/products" class="brutal-button" style="font-size: 2rem; background: var(--neon-green);">GO TO VAULT</a>
        </div>
    </div>

    <!-- Overlapping Hero Image -->
    <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&q=80" alt="Hero Loot" class="hero-image">
</section>

<section class="container" style="padding: 100px 0;">
    <div class="flex-between" style="border-bottom: 8px solid var(--brutal-black); padding-bottom: 20px; margin-bottom: 60px;">
        <h2 style="font-size: clamp(3rem, 8vw, 6rem); background: var(--accent-yellow); padding: 0 20px;">FEATURED DROPS</h2>
        <a href="/products" class="brutal-font" style="color: black; font-size: 1.2rem;">EXPLORE ALL -></a>
    </div>
    
    <div class="grid product-grid">
        @foreach($products->take(3) as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>

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
@endsection
