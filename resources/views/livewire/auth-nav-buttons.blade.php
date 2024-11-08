<div
    class="mt-10 flex grow scale-90 flex-col items-end justify-end gap-2 px-2 pt-2 md:mt-0 md:scale-100 md:flex-row md:items-center md:gap-4 md:px-8">
    @auth
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex w-max gap-1 rounded-lg bg-base-200 py-2 pl-4 pr-2 text-center text-text-primary transition duration-150 hover:bg-accent-secondary md:bg-none">
                    <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                    <div class="ms-1 mt-1">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link href="/profile" wire:navigate>
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-dropdown-link>
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </button>
            </x-slot>
        </x-dropdown>
    @else
        <a href="{{ route('login') }}" wire:navigate.hover
            class="w-24 rounded-lg bg-base-200 px-4 py-2 text-center text-text-primary transition duration-150 hover:bg-accent-secondary md:bg-none">
            Log in
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" wire:navigate.hover
                class="w-24 rounded-lg bg-base-200 px-4 py-2 text-center text-text-primary transition duration-150 hover:bg-accent-secondary md:bg-none">
                Register
            </a>
        @endif
    @endauth
</div>
