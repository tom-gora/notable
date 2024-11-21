@use(App\Helpers\UI)
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ UI::getTheme() }} no-transition">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Notable App - {{ UI::getCurrentTitle() }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:200,400i,500,700,800,800i" rel="stylesheet" />
    {{-- vite / live reload --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Styles / Scripts -->
    <link rel="stylesheet" href="{{ secure_asset('resources/css/app.css') }}?v=1">
    <script>
        // pass env type to js side for client side conditions
        const APP_ENV = "{{ config('app.env') }}";
    </script>

    {{-- js libs required by components used on /home only to load on home route --}}
    @if (UI::isHome())
        {{-- cropper --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" />
        {{-- easyMDE --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
        <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    @endif
</head>

<body class="/50  relative h-screen w-screen bg-base-100 pt-32 font-sans text-text-primary antialiased">
    @persist('topbar')
        <livewire:theme-toggle />
    @endpersist
    <livewire:sidebar-toggle />
    <livewire:sidebar />
    <livewire:topbar />
    <main id="slot-content" class=" {{ UI::getSidebarState() ? 'pl-64' : 'pl-16' }} transition-all duration-300">
        {{ $slot }}
    </main>
</body>

</html>
