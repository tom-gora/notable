<div class="h-screen w-screen grid place-items-center pr-4 md:pr-0">
    <x-mary-form
        class="w-9/12 ml-8 md:ml-auto -translate-y-1/2 rounded-xl bg-base-300 p-8 mx-auto md:w-fit flex flex-col gap-2"
        wire:submit="register">
        <!-- Name -->
        <x-mary-input wire:model="name" id="name" :label="__('Name')" type="text" error-field="name_error" inline
            clearable class="base-input" error-class="form-error-custom" required autocomplete="name" />
        <!-- Email Address -->
        <x-mary-input wire:model="email" id="email" :label="__('Email')" type="email" error-field="email_error"
            inline clearable class="base-input" error-class="form-error-custom" required autocomplete="username" />
        <!-- Password -->
        <x-mary-password wire:model="password" id="password" :label="__('Password')" type="password" inline clearable
            error-field="pass_error" class="base-input" error-class="form-error-custom" required
            autocomplete="current-password" />
        <!-- Confirm Password -->
        <x-mary-password wire:model="password_confirmation" id="password_confirmation" :label="__('Retype Password')" type="password"
            inline clearable class="base-input" error-class="form-error-custom" required autocomplete="new-password" />
        <div class="mt-4 flex gap-8 items-center justify-end">
            <x-anchor-warn href="{{ route('login') }}" content="{{ __('Already registered?') }}" :navigate="true" />
            <x-mary-button type="submit" class="btn-secondary">
                {{ __('Register') }}
            </x-mary-button>
        </div>
    </x-mary-form>
</div>
