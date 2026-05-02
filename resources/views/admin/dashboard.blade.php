@extends('admin.layout')

@section('content')
<div class="admin-hero-module" style="margin-bottom: 50px; border: 4px solid #000; box-shadow: 12px 12px 0px #000; background: #000; overflow: hidden; position: relative; height: 250px;">
    <img src="{{ asset('images/admin_hero.jpg') }}" alt="System Dashboard Alpha" 
         onerror="this.src='https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2000&auto=format&fit=crop'"
         style="width: 100%; height: 100%; object-fit: cover; opacity: 0.7; filter: grayscale(1) contrast(1.2);">
    
    <div style="position: absolute; bottom: 20px; right: 20px; background: var(--neon-green); color: #000; padding: 10px 20px; font-weight: 900; border: 3px solid #000; box-shadow: 6px 6px 0px #000;">
        [MODULE_STATUS: DATA_VIS_v2.0]
    </div>
    
    <div style="position: absolute; top: 20px; left: 20px; background: rgba(0,0,0,0.8); color: #fff; padding: 5px 12px; font-size: 0.6rem; font-weight: 900; border: 1px solid var(--neon-green);">
        CORE_DASH_IMAGE_BUFFER :: LOADED
    </div>
</div>

<div style="margin-bottom: 50px; position: relative;">
    <div style="position: absolute; top: -30px; left: 0; font-size: 0.55rem; font-weight: 900; color: #888;">[STATUS: ONLINE] [SYNC: OK] [ENCRYPTION: ACTIVE]</div>
    <div class="flex" style="align-items: flex-end; gap: 15px;">
        <h1 style="font-size: 4rem; font-weight: 900; line-height: 0.8; letter-spacing: -3px; margin: 0;">COMMAND_CENTER</h1>
        <div style="width: 120px; height: 8px; background: #000; margin-bottom: 6px;"></div>
    </div>
    <p class="brutal-font" style="font-size: 1.1rem; background: #000; color: var(--neon-green); display: inline-block; padding: 6px 15px; margin-top: 20px; font-weight: 900; transform: skewX(-10deg);">
        [SYSTEM_STABLE_V2.0.78]
    </p>
</div>

<div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 25px; margin-bottom: 50px;">
    <div class="admin-stat-card">
        <div style="position: absolute; top: 0; right: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">LIVE_DATA</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid #000; display: inline-block;">[TOTAL_PRODUCTS]</p>
        <h2 style="font-size: 3.5rem; line-height: 1; margin: 0; font-weight: 900;">{{ count($products) }}</h2>
    </div>
    <div class="admin-stat-card" style="background: var(--neon-green);">
        <div style="position: absolute; top: 0; right: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">ACTIVE_TX</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid #000; display: inline-block;">[TOTAL_ORDERS]</p>
        <h2 style="font-size: 3.5rem; line-height: 1; margin: 0; font-weight: 900;">12</h2>
    </div>
    <div class="admin-stat-card" style="background: #000; color: #fff; border-color: var(--neon-green);">
        <div style="position: absolute; top: 0; right: 0; background: var(--neon-green); color: #000; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">SHIPPED</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid var(--neon-green); display: inline-block;">[ITEMS_SOLD]</p>
        <h2 style="font-size: 3.5rem; line-height: 1; margin: 0; font-weight: 900; color: var(--neon-green);">87</h2>
    </div>
    <div class="admin-stat-card" style="background: var(--accent-yellow);">
        <div style="position: absolute; bottom: 0; right: 0; background: #000; color: #fff; padding: 2px 8px; font-size: 0.45rem; font-weight: 900;">IDR_VAL</div>
        <p style="font-size: 0.7rem; font-weight: 900; margin-bottom: 15px; border-bottom: 2px solid #000; display: inline-block;">[TOTAL_REVENUE]</p>
        <h2 style="font-size: 2.5rem; line-height: 1; margin: 0; font-weight: 900;">Rp 247.5M</h2>
    </div>
</div>

<div class="admin-stat-card" style="margin-bottom: 50px; padding: 35px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            <h3 style="font-size: 1.5rem; border-left: 8px solid #000; padding-left: 15px; line-height: 1; margin: 0; font-weight: 900;">REVENUE_METRICS_V01</h3>
            <p style="font-size: 0.65rem; font-weight: 900; margin-top: 8px; opacity: 0.5;">[DATA_STREAM_ACTIVE] [SAMPLING_RATE: 1.0HZ]</p>
        </div>
        <div style="text-align: right;">
            <div style="background: #000; color: var(--neon-green); padding: 4px 12px; font-weight: 900; font-size: 0.75rem;">SYNC_OK :: NODE_ALPHA</div>
        </div>
    </div>
    
    <div style="height: 300px; background: #000; border: 4px solid #000; display: flex; align-items: flex-end; gap: 12px; padding: 25px 25px 25px 55px; position: relative;">
        <!-- Y-AXIS VALUES -->
        <div style="position: absolute; left: 10px; top: 30px; bottom: 30px; display: flex; flex-direction: column; justify-content: space-between; font-size: 0.6rem; font-weight: 900; color: #555; text-align: right; width: 40px; pointer-events: none;">
            <div>100%</div>
            <div>80%</div>
            <div>60%</div>
            <div>40%</div>
            <div>20%</div>
            <div>0%</div>
        </div>

        <div style="position: absolute; left: 55px; top: 30px; bottom: 30px; width: 2px; background: #222;"></div>
        <div style="position: absolute; left: 60px; right: 30px; bottom: 25px; height: 1px; color: #555; font-size: 0.5rem; font-weight: 900; letter-spacing: 2px;">[Y_AXIS_VALUES] [DATA_SCALE: LOG_V1]</div>

        <!-- GRID LINES -->
        <div style="position: absolute; top: 30px; left: 60px; right: 30px; border-top: 1px dashed #222;"></div>
        <div style="position: absolute; top: 20%; left: 60px; right: 30px; border-top: 1px dashed #222;"></div>
        <div style="position: absolute; top: 40%; left: 60px; right: 30px; border-top: 1px dashed #222;"></div>
        <div style="position: absolute; top: 60%; left: 60px; right: 30px; border-top: 1px dashed #222;"></div>
        <div style="position: absolute; top: 80%; left: 60px; right: 30px; border-top: 1px dashed #222;"></div>
        <div style="position: absolute; bottom: 30px; left: 60px; right: 30px; border-top: 1px dashed #222; border-top-style: solid;"></div>
        
        <!-- DUMMY CHART -->
        <div style="background: #222; height: 40%; flex: 1; border: 1px solid #444; position: relative; z-index: 1;"></div>
        <div style="background: #333; height: 65%; flex: 1; border: 1px solid #444; position: relative; z-index: 1;"></div>
        <div style="background: var(--neon-green); height: 90%; flex: 1; border: 1px solid #000; position: relative; z-index: 1; box-shadow: 0px 0px 20px rgba(163, 255, 0, 0.3);"></div>
        <div style="background: #222; height: 50%; flex: 1; border: 1px solid #444; position: relative; z-index: 1;"></div>
        <div style="background: var(--neon-green); height: 75%; flex: 1; border: 1px solid #000; position: relative; z-index: 1;"></div>
        <div style="background: #222; height: 45%; flex: 1; border: 1px solid #444; position: relative; z-index: 1;"></div>
        <div style="background: #333; height: 60%; flex: 1; border: 1px solid #444; position: relative; z-index: 1;"></div>
        <div style="background: #222; height: 55%; flex: 1; border: 1px solid #444; position: relative; z-index: 1;"></div>
    </div>

    <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
        <div style="background: #eee; padding: 12px; border: 2px solid #000; font-size: 0.65rem; font-weight: 900;">
            [CORE_TEMP]: 42°C
        </div>
        <div style="background: #eee; padding: 12px; border: 2px solid #000; font-size: 0.65rem; font-weight: 900;">
            [BUFFER_LOAD]: 12%
        </div>
        <div style="background: #eee; padding: 12px; border: 2px solid #000; font-size: 0.65rem; font-weight: 900;">
            [SIGNAL_STRENGTH]: MAX
        </div>
    </div>
</div>

<section style="margin-bottom: 50px;">
    <div class="flex-between" style="border-bottom: 6px solid #000; padding-bottom: 15px; margin-bottom: 30px;">
        <h2 style="font-size: 2.5rem; font-weight: 900; margin: 0; line-height: 1;">ACTIVE_INVENTORY_ALPHA</h2>
        <a href="/admin/products" style="font-size: 0.8rem; font-weight: 900; color: #000;">FULL_DATABASE -></a>
    </div>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
        @foreach($products->take(3) as $product)
            <x-product-card :product="$product" isAdmin="true" />
        @endforeach
    </div>
</section>
@endsection
