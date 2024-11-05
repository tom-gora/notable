@use(App\Helpers\UI)
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ UI::getTheme() }} no-transition">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Notable App - {{ UI::getCurrentTitle() }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:200,400i,500,700,800,800i" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="/50 relative h-screen w-screen bg-base-100 pt-32 font-sans text-text-primary antialiased">
    @persist('topbar')
        <livewire:theme-toggle />
        <livewire:topbar />
    @endpersist
    <livewire:sidebar-toggle />
    <livewire:sidebar />
    <main id="slot-content" class=" {{ UI::getSidebarState() ? 'pl-64' : '' }} transition-all duration-300">
        {{ $slot }}
    </main>
</body>

</html>
