<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Raport</title>
    @vite('resources/css/app.css') {{-- Pastikan Tailwind/Styling ter-load --}}
</head>
<body class="bg-gray-100 text-gray-900">
    <main class="container mx-auto p-4">
        @yield('content')
    </main>
</body>
</html>
