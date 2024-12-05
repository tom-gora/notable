<div class="grid h-screen w-screen place-items-center pr-4 md:pr-0">
    <x-mary-form
        class="bg-base-300 mx-auto ml-8 flex w-9/12 -translate-y-1/2 flex-col gap-2 rounded-xl p-8 md:ml-auto md:w-fit"
        wire:submit="register">
        <!-- Name -->
        <x-mary-input :label="__('Name')" autocomplete="name" class="base-input" clearable error-class="form-error-custom"
            error-field="name_error" id="name" inline required type="text" wire:model="name" />
        <!-- Email Address -->
        <x-mary-input :label="__('Email')" autocomplete="username" class="base-input" clearable
            error-class="form-error-custom" error-field="email_error" id="email" inline required type="email"
            wire:model="email" />
        <!-- Password -->
        <x-mary-password :label="__('Password')" autocomplete="current-password" class="base-input" clearable
            error-class="form-error-custom" error-field="pass_error" id="password" inline required type="password"
            wire:model="password" />
        <!-- Confirm Password -->
        <x-mary-password :label="__('Retype Password')" autocomplete="new-password" class="base-input" clearable
            error-class="form-error-custom" id="password_confirmation" inline required type="password"
            wire:model="password_confirmation" />
        <div class="mt-4 flex items-center justify-end gap-8">
            <a class="form-anchor" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-mary-button :label="__('Register')" class="btn-secondary" type="submit" />
        </div>
    </x-mary-form>
</div>
