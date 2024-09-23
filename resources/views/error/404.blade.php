<!-- resources/views/errors/404.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Page Not Found</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800">404</h1>
            <p class="mt-4 text-lg text-gray-600">Oups ! La page que vous recherchez n'existe pas. vous devez selectionne une entreprise</p>
            <p class="mt-2 text-sm text-gray-500">Retournez à <a href="{{ url('/') }}" class="text-blue-600 hover:underline">la page d'accueil</a>.</p>
        </div>
    </div>
</body>
</html>
