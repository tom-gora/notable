{{-- adapted from https://flowbite.com/docs/components/sidebar/ --}}
<nav id="drawer-navigation"
    class="fixed  top-0 z-40 flex h-screen w-screen md:w-64 {{ $sidebarState ? '' : '-translate-x-[calc(100%-4.8rem)]' }} flex-col-reverse overflow-y-auto bg-base-200 p-4 text-text-primary transition-transform duration-300"
    tabindex="-1" aria-labelledby="drawer-navigation-label" aria-expanded="{{ $sidebarState ? 'true' : 'false' }}">
    <div class="flex h-full flex-col justify-end overflow-y-auto py-4 pt-4">
        <ul class="flex flex-col-reverse gap-2 py-4 font-medium">
            @foreach ($links as $link)
                <livewire:sidebar-link :title="$link[1]" :href="$link[0]" :offset="$loop->last ? 'pb-8' : ''" :icon="$link[2]"
                    :current="$this->isCurrent($link[0])" :sidebarState="$sidebarState">
            @endforeach
        </ul>
    </div>
</nav>
