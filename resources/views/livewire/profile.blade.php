<div class="py-12 pl-24 pr-6">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-base-200 p-4 md:p-8">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="md:grid md:grid-cols-5 gap-6 flex flex-col">
            <div class="col-span-3 rounded-lg bg-base-200 p-4 md:p-8">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="col-span-2 rounded-lg bg-base-200 p-4 md:p-8">
                <div class="max-w-xl">
                    <livewire:delete-user-form />
                </div>
            </div>
        </div>
    </div>
</div>
