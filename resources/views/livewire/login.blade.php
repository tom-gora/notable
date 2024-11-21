<div class="h-screen w-screen grid place-items-center pr-4 md:pr-0">
    <!-- Session Status -->
    @if (session()->has('status'))
        <x-mary-alert icon="o-exclamation-triangle"
            class="alert-success text-text-primary z-50 !pb-0 w-9/12 md:w-4/12 absolute right-4 md:right-16 translate-x-1/2 text-xs top-32 md:bottom-auto md:top-24 alert-slide-out">
            {{ session('status') }}
        </x-mary-alert>
    @endif

    <x-mary-form
        class="w-9/12 ml-8 md:ml-auto -translate-y-1/2 rounded-xl bg-base-300 p-8 mx-auto md:w-fit flex flex-col gap-2"
        wire:submit.prevent="login">
        <div class="flex flex-col gap-4">
            <!-- Email -->
            <x-mary-input wire:model="form.email" id="email" :label="__('Email')" type="email" inline clearable
                error-field="email_error" class="base-input" error-class="form-error-custom" required autofocus />
            <!--Password-->
            <x-mary-password wire:model="form.password" id="password" :label="__('Password')" type="password" inline
                clearable error-field="pass_error" class="base-input" error-class="form-error-custom" required
                autocomplete="current-password" />
        </div>
        <x-mary-checkbox class="base-checkbox mt-4" label="{{ __('Remember me') }}" wire:model="form.remember" right />

        <div class="mt-4 gap-8 flex items-center justify-end">
            @if (Route::has('forgot-password'))
                <x-anchor-warn href="{{ route('forgot-password') }}" content="{{ __('Forgot your password?') }}"
                    :navigate="true" />
            @endif

            <x-mary-button type="submit" class="btn-secondary">
                {{ __('Log in') }}
            </x-mary-button>
        </div>
    </x-mary-form>
</div>
