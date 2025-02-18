    <div class="flex h-max w-[96%] grow flex-col items-center justify-center gap-4 pt-14 md:w-full md:pt-4">
        <livewire:navs.nav-components.topbar-greeting :welcome="true" />
        {{-- inline encoded svg to take advantage of css variables --}}
        <div class="ml-6 grid h-full w-10/12 place-items-center md:ml-0 md:w-full">
            <x-svgs.no-auth-svg-01 />
            <h2 class="py-4 text-center text-xl md:text-2xl">Login to start working with handwritten notes 🚀🚀🚀</h1>
        </div>
    </div>
