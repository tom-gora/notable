<div class="flex flex-col w-full max-h-[75vh] overflow-scroll scroll-smooth px-8 py-4 relative">
    <div class="items-end flex flex-col gap-4 justify-between self-end fixed w-min">
        <x-mary-button class="btn-primary me-2" label="Close" wire:click="closePreview" />
        <x-mary-button tooltip-left="{{ $this->isSnapshot ? 'Toggle transcript' : 'Toggle snapshot' }}"
            wire:click="toggleSnapshot" class="accordion-btn-edit z-10 !mr-2 before:!right-10"><span
                class="{{ $this->isSnapshot ? 'solar--document-text-line-duotone' : 'solar--eye-scan-line-duotone' }} !text-3xl iconify"></span></x-mary-button>
    </div>
    <p class="text-text-primary text-xl font-bold mb-2">Viewing note:</p>
    <h3 class="text-2xl text-accent-secondary flex justify-start gap-2">"{{ $data['title'] }}"</h3>
    @if (!$this->isSnapshot)
        <div id="html-target" class="prose w-full h-full p-8">
            {!! $data['html'] !!}
        </div>
    @else
        <img src="{{ $data['snapshot'] }}" alt="Snapshot" class="w-full h-full object-contain mt-8">
    @endif
</div>
