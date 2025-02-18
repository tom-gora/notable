<div class="py-12 pl-24 pr-6">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="bg-base-200 rounded-lg p-4 md:p-8">
            <div class="max-w-xl">
                <livewire:forms.profile-information-form />
            </div>
        </div>

        <div class="flex flex-col gap-6 md:grid md:grid-cols-5">
            <div class="bg-base-200 col-span-3 rounded-lg p-4 md:p-8">
                <div class="max-w-xl">
                    <livewire:forms.update-password-form />
                </div>
            </div>

            <div class="bg-base-200 col-span-2 rounded-lg p-4 md:p-8">
                <div class="max-w-xl">
                    <livewire:forms.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</div>
