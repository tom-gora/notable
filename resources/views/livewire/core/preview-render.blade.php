<div class="relative flex max-h-[75vh] w-full flex-col overflow-scroll scroll-smooth px-8 py-4">
    <div class="fixed flex w-min flex-col items-end justify-between gap-4 self-end">
        <x-mary-button class="btn-primary me-2" label="Close" wire:click="closePreview" />
        <x-mary-button :tooltip-left="$this->isSnapshot ? 'Toggle transcript' : 'Toggle snapshot'" class="accordion-btn-edit z-10 !mr-2 before:!right-10"
            wire:click="toggleSnapshot"><span
                class="{{ $this->isSnapshot ? 'solar--document-text-line-duotone' : 'solar--eye-scan-line-duotone' }} iconify !text-3xl"></span></x-mary-button>
    </div>
    <p class="text-text-primary mb-2 text-xl font-bold">{{ __('Viewing note:') }}</p>
    <h3 class="text-accent-secondary flex justify-start gap-2 text-2xl">"{{ $this->data['title'] }}"</h3>
    @if (!$this->isSnapshot)
        <div class="prose h-full w-full p-8" id="html-target">
            {!! $this->data['html'] !!}
        </div>
    @else
        <img :alt="__('Note snapshot')" class="mt-8 h-full w-full object-contain" src="{{ $this->data['snapshot'] }}">
    @endif
</div>