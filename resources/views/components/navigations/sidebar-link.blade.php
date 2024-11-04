@props(['icon', 'href', 'current', 'offset'])
@use(App\Helpers\UI)

<li class="{{ $offset }}">
    <a href="{{ $href }}"
        class="group flex gap-8 items-center ml-auto justify-end rounded-lg p-2 text-text-primary hover:bg-accent-secondary {{ $current ? 'bg-base-100 font-medium' : ' ' }} {{ UI::getSidebarState() ? '' : 'w-12' }}">
        <span class="ms-3">
            {{ $slot }}
        </span>
        <span class="{{ $icon }} iconify text-3xl mr-[1px] aspect-square"></span>
    </a>
</li>
