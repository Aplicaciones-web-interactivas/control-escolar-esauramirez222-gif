<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Control Escolar')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <h1 class="text-2xl font-bold text-gray-800">Control Escolar</h1>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </div>

    <footer class="bg-gray-800 text-white mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Control Escolar. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>