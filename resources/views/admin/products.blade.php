@extends('admin.layout')

@section('content')

<div class="flex-between" style="margin-bottom: 40px; align-items: flex-end;">
    <div>
        <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -2px; margin-bottom: 20px;">PRODUCT_DATABASE</h1>
        <div style="display: flex; gap: 10px; align-items: center;">
            <div style="background: black; color: white; padding: 12px 15px; font-weight: 900; font-size: 0.7rem; border: 4px solid black;">[SEARCH_QUERY]</div>
            <input type="text" id="admin-search-input" placeholder="SEARCH_PRODUCT_NAME / ID / CATEGORY"
                   style="border: 4px solid black; padding: 10px 20px; width: 400px; font-weight: 900; outline: none; background: #fff; font-family: inherit;">
        </div>
    </div>
    <a href="/admin/products/create" class="brutal-button" style="background: var(--neon-green); padding: 8px 25px; text-decoration: none; color: #000; font-size: 0.9rem;">+ ADD_NEW_ITEM</a>
</div>

<div class="grid product-grid" id="admin-product-list" style="gap: 30px;">
    @forelse ($products as $product)
        <div class="admin-product-wrapper"
             data-search="{{ $product->id }} {{ strtolower($product->name) }} {{ strtolower($product->category) }}">
            <x-product-card :product="$product" :isAdmin="true" />
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 60px; font-weight: 900; opacity: 0.4;">[NO_PRODUCTS_FOUND]</div>
    @endforelse
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('admin-search-input');
    const wrappers    = document.querySelectorAll('.admin-product-wrapper');

    searchInput?.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        wrappers.forEach(wrapper => {
            const match = wrapper.getAttribute('data-search').includes(query);
            wrapper.style.display = match ? '' : 'none';
        });
    });

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.delete-product-btn');
        if (!btn) return;

        const { id, name } = btn.dataset;

        window.BrutalModal.confirm(
            'PURGE_PRODUCT?',
            `THIS ACTION WILL REMOVE [${name}] FROM THE VAULT. ⚠ PERMANENT — ✕ NO_RECOVERY`,
            () => {
                fetch(`/admin/products/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: '_method=DELETE'
                })
                .then(res => {
                    if (res.ok || res.redirected) {
                        const card = btn.closest('.admin-product-wrapper');
                        card.style.transition = 'opacity 0.3s, transform 0.3s';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        setTimeout(() => card.remove(), 300);

                        window.BrutalModal.confirm(
                            'PRODUCT_PURGED',
                            `[${name}] HAS BEEN REMOVED FROM THE VAULT.`,
                            null,
                            'OK',
                            null
                        );
                    }
                })
                .catch(err => console.error('FETCH ERROR:', err));
            },
            'CONFIRM_PURGE',
            'CANCEL_OPS'
        );
    });
});
</script>

@endsection