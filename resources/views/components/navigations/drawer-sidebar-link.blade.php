@props(['icon', 'href'])
<li>
    <a href="{{ $href }}"
        class="flex items-center p-2 text-text-primary rounded-lg hover:bg-accent-secondary-focusgroup">
        <span class="text-3xl  iconify {{ $icon }}"></span>
        <span class="ms-3">
            {{ $slot }}
        </span>
    </a>
</li>
