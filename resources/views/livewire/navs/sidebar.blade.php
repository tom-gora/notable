{{-- adapted from https://flowbite.com/docs/components/sidebar/ --}}
<nav aria-expanded="{{ $sidebarState ? 'true' : 'false' }}" aria-labelledby="drawer-navigation-label"
    class="{{ $sidebarState ? '' : '-translate-x-[calc(100%-4.8rem)]' }} bg-base-200 text-text-primary fixed top-0 z-40 flex h-screen w-screen flex-col-reverse overflow-y-auto p-4 transition-transform duration-300 md:w-64"
    id="drawer-navigation" tabindex="-1">
    <div class="flex h-full flex-col justify-end overflow-y-auto py-4 pt-4">
        <ul class="flex flex-col-reverse gap-2 py-4 font-medium">
            @foreach ($links as $link)
                {{-- at auth render all links --}}
                @auth
                    <livewire:navs.nav-components.sidebar-link :current="$this->isCurrent($link[0])" :href="$link[0]" :icon="$link[2]"
                        :offset="$loop->last ? 'pb-8' : ''" :sidebarState="$sidebarState" :title="$link[1]">
                    @else
                        {{-- at auth render only home and settings --}}
                        @if ($link[3])
                            <livewire:navs.nav-components.sidebar-link :current="$this->isCurrent($link[0])" :href="$link[0]" :icon="$link[2]"
                                :offset="$loop->last ? 'pb-8' : ''" :sidebarState="$sidebarState" :title="$link[1]">
                        @endif
                    @endauth
            @endforeach
        </ul>
    </div>
</nav>