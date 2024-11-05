@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-none bg-neutral-content text-neutral py-1 px-2 focus-visible:!outline-none focus-visible:!ring-accent-secondary focus-visible:!ring-2 rounded-md shadow-sm']) }}>
