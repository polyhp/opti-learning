<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OPTI-LEARNING')</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen">
        @if(!request()->routeIs('login') && !request()->routeIs('register*'))
            @include('layouts.partials.navbar')
        @endif
        
        <main class="relative">
            @yield('content')
        </main>
        
        @if(!request()->routeIs('login') && !request()->routeIs('register*'))
            @include('layouts.partials.footer')
        @endif
    </div>
    
    @stack('scripts')
</body>
</html>