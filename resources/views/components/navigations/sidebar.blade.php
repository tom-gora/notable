@use(App\Helpers\UI)

{{-- adapted from https://flowbite.com/docs/components/sidebar/ --}}
<div id="drawer-navigation"
    class="fixed  top-0 z-40 flex h-screen w-64 {{ UI::getSidebarState() ? '' : '-translate-x-[calc(100%-4.8rem)]' }} flex-col-reverse overflow-y-auto bg-base-200 p-4 text-text-primary transition-transform duration-300"
    tabindex="-1" aria-labelledby="drawer-navigation-label"
    aria-expanded="{{ UI::getSidebarState() ? 'true' : 'false' }}">
    <div class="overflow-y-auto py-4">
        <ul class="flex flex-col-reverse space-y-2 py-4 font-medium">
            @foreach (UI::$SIDEBAR_LINKS as $link)
                <x-navigations.sidebar-link :href="$link[0]" :offset="$loop->last ? 'pb-8' : ''" :icon="$link[2]" :current="UI::isCurrent($link[0])">
                    {{ $link[1] }}
                    </x-navigations.drawer-sidebar-link>
            @endforeach
        </ul>
    </div>
</div>
