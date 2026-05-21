<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOID_STREET // RAW FUTURE WEAR</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/brutal-modal.js'])
</head>
<body>
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('components.modal')

    @auth
        <script>
            async function updateCartBadge() {
                const res = await fetch('/cart/summary');
                if (!res.ok) return;
                const data = await res.json();
                const badge = document.querySelector('.cart-badge');
                if (badge) badge.textContent = data.count;
            }
            updateCartBadge();

            function toggleWishlist(btn, productId) {
                fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.saved) {
                        btn.innerHTML = '♥';
                        btn.style.background = 'black';
                        btn.style.color = 'white';
                        btn.dataset.wishlisted = 'true';
                    } else {
                        btn.innerHTML = '♡';
                        btn.style.background = 'white';
                        btn.style.color = 'black';
                        btn.dataset.wishlisted = 'false';
                    }
                });
            }
        </script>
    @endauth
</body>
</html>