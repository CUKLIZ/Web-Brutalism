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
        </script>
    @endauth

    <!-- Preview Shim Helper -->
    <script>
        // If Vite is not running (production or shim), we might need fallback paths
        // But for this preview, we'll assume the shim handles the CSS/JS        
    </script>   
</body>
</html>
