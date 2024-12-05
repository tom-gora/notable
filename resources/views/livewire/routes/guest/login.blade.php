<div class="grid h-screen w-screen place-items-center pr-4 md:pr-0">
    <!-- Session Status -->
    @if (session()->has('status'))
        <x-mary-alert
            class="alert-success text-text-primary animate-slide-out absolute right-4 top-32 z-50 w-9/12 translate-x-1/2 !pb-0 text-xs md:bottom-auto md:right-16 md:top-24 md:w-4/12"
            icon="o-exclamation-triangle">
            {{ session('status') }}
        </x-mary-alert>
    @endif

    <x-mary-form
        class="bg-base-300 mx-auto ml-8 flex w-9/12 -translate-y-1/2 flex-col gap-2 rounded-xl p-8 md:ml-auto md:w-fit"
        wire:submit.prevent="login">
        <div class="flex flex-col gap-4">
            <!-- Email -->
            <x-mary-input :label="__('Email')" autofocus class="base-input" clearable error-class="form-error-custom"
                error-field="email_error" id="email" inline required type="email" wire:model="form.email" />
            <!--Password-->
            <x-mary-password :label="__('Password')" autocomplete="current-password" class="base-input" clearable
                error-class="form-error-custom" error-field="pass_error" id="password" inline required type="password"
                wire:model="form.password" />
        </div>
        <x-mary-checkbox class="base-checkbox mt-4" label="{{ __('Remember me') }}" right wire:model="form.remember" />

        <div class="mt-4 flex items-center justify-end gap-8">
            @if (Route::has('forgot-password'))
                <a class="form-anchor" href="{{ route('forgot-password') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-mary-button :label="__('Log in')" class="btn-secondary" type="submit" />
        </div>
    </x-mary-form>
</div>
