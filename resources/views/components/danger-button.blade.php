<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-error border border-transparent rounded-lg font-semibold text-xs text-accent-primary-content uppercase tracking-widest hover:bg-accent-primary-focus focus-visible:bg-accent-primary-focus active:bg-accent-primary-subtle focus-visible:outline-none focus:ring-2 focus-visible:ring-accent-primary-focus transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
