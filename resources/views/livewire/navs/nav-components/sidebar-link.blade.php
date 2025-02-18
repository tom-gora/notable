<li class="{{ $offset }}" role="nav-link">
    <a class="text-text-primary hover:bg-accent-secondary {{ $sidebarState ? '' : 'w-12' }} group ml-auto mr-1 flex items-center justify-end gap-8 rounded-lg p-2 transition duration-100"
        href="{{ $href }}" wire:current="bg-base-100 font-medium" wire:navigate>
        <span class="ms-3">
            {{ $title }}
        </span>
        <span class="{{ $icon }} iconify mr-[1px] aspect-square text-3xl"></span>
    </a>
</li>
