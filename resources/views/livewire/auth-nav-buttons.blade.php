<div
    class="relative z-50 flex scale-90 flex-col items-end justify-end gap-2 px-2 pt-2 md:mt-0 md:scale-100 md:flex-row md:items-center md:gap-4 md:px-8">
    @auth
        <x-dropdown align="right" width="48" class="!-transform-y-2">
            <x-slot name="trigger">
                <x-mary-button class="btn-secondary">
                    <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name">
                    </div>

                    <div class="ms-1 mt-1">
                        <svg class="h-6 w-6 -mt-1 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </x-mary-button>
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
        <div class="translate-y-2 flex gap-4"><x-mary-button link="{{ route('login') }}" class="btn-secondary w-24"
                wire:navigate.hover label="Log in" />

            @if (Route::has('register'))
                <x-mary-button link="{{ route('register') }}" class="btn-secondary w-24" wire:navigate.hover
                    label="Register" />
            @endif
        </div>
    @endauth
</div>
