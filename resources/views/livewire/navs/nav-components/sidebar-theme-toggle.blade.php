<div class="fixed left-1 top-20 z-50 flex w-16 grow scale-90 justify-center md:grow-0 md:scale-100">
    <button aria-label="Toggle theme"
        class="{{ $sidebarState ? 'translate-x-[calc(100vw-160%)] md:translate-x-44' : '' }} focus-visible:ring-accent-secondary bg-accent-secondary-subtle flex h-8 w-[52px] items-center rounded-full transition duration-200 focus:outline-none focus-visible:ring-2"
        role="switch">
        <div class="{{ $theme == 'dark' ? 'bg-info translate-x-6' : 'bg-warning translate-x-1' }} text-accent-primary-content relative aspect-square w-6 transform rounded-full p-1 transition duration-200"
            id="theme-toggle">
            <svg class="stroke-accent-primary-subtle fill-none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </div>
    </button>
</div>
