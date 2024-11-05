<li class="{{ $offset }}">
    <a href="{{ $href }}" wire:navigate.hover
        class="group ml-auto mr-1 flex gap-8 items-center  justify-end rounded-lg p-2 text-text-primary transition duration-150 hover:bg-accent-secondary {{ $current ? 'bg-base-100 font-medium' : ' ' }} {{ $sidebarState ? '' : 'w-12' }}">
        <span class="ms-3">
            {{ $title }}
        </span>
        <span class="{{ $icon }} iconify text-3xl mr-[1px] aspect-square"></span>
    </a>
</li>
