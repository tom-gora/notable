@php
    $links = [
        ['/transcripts', 'Transcripts', 'hugeicons--quill-write-02'],
        ['/snapshots', 'Snapshots', 'solar--eye-scan-bold-duotone'],
        ['/archive', 'Archive', 'solar--inbox-archive-line-duotone'],
        ['/collections', 'Collections', 'solar--widget-2-line-duotone'],
        ['/bookmarks', 'Bookmarks', 'solar--notebook-bookmark-bold-duotone'],
    ];
@endphp

{{-- NOTE: base src https://flowbite.com/docs/components/sidebar/ --}}
<div id="drawer-navigation"
    class="text-text-primary absolute top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto -translate-x-full transition-transform duration-300 bg-base-300"
    tabindex="-1" aria-labelledby="drawer-navigation-label" aria-expanded="false">
    <h5 id="drawer-navigation-label" class="text-end px-4 pt-1 text-base font-semibold text-accent-secondary uppercase ">
        Menu
    </h5>
    <div class="py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <x-navigations.drawer-sidebar-link href="{{ $link[0] }}" icon="{{ $link[2] }}">
                    {{ $link[1] }}
                </x-navigations.drawer-sidebar-link>
            @endforeach
        </ul>
    </div>
</div>
