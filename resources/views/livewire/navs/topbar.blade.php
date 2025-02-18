@use(App\Helpers\UI)
<nav class="{{ UI::getSidebarState() ? 'pl-80' : 'pl-32' }} bg-base-100 shadow-base-200/75 absolute top-0 z-30 mt-8 flex h-20 w-screen flex-row-reverse items-center justify-between pr-1 transition-all duration-200 md:fixed md:mt-0 md:flex-row md:pr-8"
    id="secondary-nav">
    @auth
        <livewire:navs.nav-components.topbar-greeting />
    @endauth

    <a class="md:clamped-logo sm-fixed-logo absolute -top-3 z-50 h-6 w-fit cursor-pointer md:top-1/4 md:h-8"
        href="/home" wire:navigate.hover>
        <x-svgs.app-logo />
    </a>
    <livewire:navs.nav-components.topbar-buttons />
</nav>
