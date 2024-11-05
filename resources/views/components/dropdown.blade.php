@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'overflow-hidden bg-base-200'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    $width = match ($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" x-transition:enter="transition duration-150 ease-out" x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100" x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-95 opacity-0"
        class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;" @click="open = false">
        <div class="text-text-primary rounded-lg {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
