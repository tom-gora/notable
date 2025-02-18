@use(App\Helpers\UI)
<!DOCTYPE html>
<html class="{{ UI::getTheme() }} no-transition" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token" />

        <title>Notable App - {{ UI::getCurrentTitle() }}</title>

        <link href="/favicon.svg" rel="icon" type="image/svg+xml" />

        <!-- Fonts -->
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=poppins:200,400i,500,700,800,800i" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- js libs required by components used on /home only to load on home route --}}
        @if (UI::isHome())
            {{-- cropper --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet" />
            {{-- easyMDE --}}
            <link href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
        @endif
    </head>

    <body
        class="bg-base-100 text-text-primary relative min-h-screen w-screen overflow-y-scroll pt-24 font-sans antialiased md:max-h-none">
        @persist('toggles')
            <livewire:navs.nav-components.sidebar-theme-toggle />
            <livewire:navs.nav-components.sidebar-toggle />
            <livewire:navs.sidebar />
        @endpersist
        <livewire:navs.topbar />
        <main class="{{ UI::getSidebarState() ? 'pl-64 main-offset' : 'pl-16' }} transition-all duration-200"
            id="slot-content">
            {{ $slot }}
        </main>
    </body>

</html>
