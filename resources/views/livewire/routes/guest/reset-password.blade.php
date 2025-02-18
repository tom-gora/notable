<div class="grid h-screen w-screen place-items-center pr-4 md:pr-0">
    <x-mary-form
        class="bg-base-300 mx-auto ml-8 flex w-9/12 -translate-y-1/2 flex-col gap-2 rounded-xl p-8 md:ml-auto md:w-fit"
        wire:submit.prevent="resetPassword">
        <div class="flex flex-col gap-4 pb-4">
            <!-- Email -->
            <x-mary-input :label="__('Email')" autofocus class="base-input" clearable error-class="form-error-custom"
                error-field="email_error" id="email" inline required type="email" wire:model="email" />
            <!--Password-->
            <x-mary-password :label="__('Password')" autocomplete="current-password" class="base-input" clearable
                error-class="form-error-custom" error-field="pass_error" id="password" inline required type="password"
                wire:model="password" />
            <x-mary-password :label="__('Confirm Password')" autocomplete="new-password" class="base-input" clearable
                error-class="form-error-custom" id="password_confirmation" inline required type="password"
                wire:model="password_confirmation" />
        </div>

        <x-mary-button :label="__('Reset Password')" class="btn-secondary" type="submit" />
    </x-mary-form>
</div>
