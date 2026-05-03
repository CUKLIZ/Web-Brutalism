<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOOT VAULT | NEO-BRUTALIST E-COMMERCE</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <%- include('partials/navbar.blade.php') %>
    
    <main>
        <%- body %>
    </main>

    <%- include('partials/footer.blade.php') %>

    <%- include('components/modal.blade.php') %>
    <script src="/js/brutal-modal.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
