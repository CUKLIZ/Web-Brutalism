<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOOT VAULT | NEO-BRUTALIST E-COMMERCE</title>
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

    <!-- Preview Shim Helper -->
    <script>
        // If Vite is not running (production or shim), we might need fallback paths
        // But for this preview, we'll assume the shim handles the CSS/JS
    </script>   
</body>
</html>
