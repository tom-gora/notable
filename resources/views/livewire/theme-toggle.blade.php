{{-- NOTE: based off src https://www.creative-tim.com/twcomponents/component/switch-to-darkmode --}}
<div class="fixed left-1 top-20 z-50 flex w-16 grow justify-center md:grow-0">
    <button aria-label="Toggle theme" role="switch"
        class="{{ $sidebarState ? 'translate-x-[calc(100vw-160%)] md:translate-x-44' : '' }} focus-visible:ring-accent-secondary focus-visible:ring-2 flex h-8 w-[52px] items-center rounded-full bg-accent-secondary-subtle transition duration-300 focus:outline-none ">
        <div id="theme-toggle"
            class=" relative aspect-square w-6 {{ $theme == 'dark' ? 'bg-info translate-x-6' : 'bg-warning translate-x-1' }}  transform rounded-full p-1 text-accent-primary-content transition duration-300 ">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-none stroke-accent-primary-subtle">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
    </button>
</div>