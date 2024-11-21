@props(['href', 'content', 'navigate'])
<a class="text-sm text-text-subtle hover:text-warning transition-colors duration-150 focus-visible:outline-none focus-visible:underline focus:text-warning"
    href="{{ $href }}" @if ($navigate) {{ 'wire:navigate' }} @endif>
    {{ $content }}
</a>
