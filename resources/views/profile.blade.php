<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#176B4D]">Настройки аккаунта</p>
            <h1 class="mt-2 text-2xl font-semibold text-[#17211B]">Профиль</h1>
        </div>
    </x-slot>

    <div class="page-shell pt-6">
        <div class="mx-auto max-w-4xl space-y-5">
            <div class="surface-pad">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="surface-pad">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="surface-pad border-[#F0CCCC]">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
