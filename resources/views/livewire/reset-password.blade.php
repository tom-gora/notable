<div class="h-screen w-screen grid place-items-center pr-4 md:pr-0">
    <x-mary-form wire:submit.prevent="resetPassword"
        class="w-9/12 ml-8 md:ml-auto -translate-y-1/2 rounded-xl bg-base-300 p-8 mx-auto md:w-fit flex flex-col gap-2">
        <div class="flex flex-col gap-4 pb-4">
            <!-- Email -->
            <x-mary-input wire:model="email" id="email" :label="__('Email')" type="email" inline clearable
                error-field="email_error" class="base-input" error-class="form-error-custom" required autofocus />
            <!--Password-->
            <x-mary-password wire:model="password" id="password" :label="__('Password')" type="password" inline clearable
                error-field="pass_error" class="base-input" error-class="form-error-custom" required
                autocomplete="current-password" />
            <x-mary-password wire:model="password_confirmation" id="password_confirmation" :label="__('Confirm Password')"
                type="password" inline clearable class="base-input" error-class="form-error-custom" required
                autocomplete="new-password" />
        </div>

        <x-mary-button type="submit" class="btn-secondary">
            {{ __('Reset Password') }}
        </x-mary-button>
    </x-mary-form>
</div>
