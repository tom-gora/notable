<x-mary-modal box-class="bg-base-300" wire:model="del_modal">
    <div class="bg-base-300 my-5 text-lg">{{ $title }}</div>
    <div class="bg-base-300 text-text-subtle mb-5 text-sm">Are you sure you want this note permanently deleted?</div>
    <div class="flex w-full justify-end gap-8 pt-4">
        <x-mary-button @click="$wire.del_modal = false" class="btn-secondary" label="Go Back" />
        <x-mary-button class="btn-primary" label="Delete" wire:click="deleteNote({{ $id }})" />
    </div>
</x-mary-modal>
