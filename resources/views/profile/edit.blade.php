<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 fade-in">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    Meu Perfil
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Gerencie suas informações pessoais e configurações de conta
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Informações do Perfil -->
        <div class="card-minimal p-6 sm:p-8 fade-in" data-animate>
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mr-4">
                    <x-icons.user class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-300" />
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-semibold text-primary-950 dark:text-primary-50">Informações do Perfil</h2>
                    <p class="text-sm text-primary-600 dark:text-primary-400">Atualize as informações do seu perfil e endereço de email</p>
                </div>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Alterar Senha -->
        <div class="card-minimal p-6 sm:p-8 fade-in" data-animate style="animation-delay: 0.1s;">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-warning/10 rounded-xl flex items-center justify-center mr-4">
                    <x-icons.settings class="w-5 h-5 sm:w-6 sm:h-6 text-warning" />
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-semibold text-primary-950 dark:text-primary-50">Alterar Senha</h2>
                    <p class="text-sm text-primary-600 dark:text-primary-400">Certifique-se de usar uma senha longa e aleatória para manter sua conta segura</p>
                </div>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Excluir Conta -->
        <div class="card-minimal p-6 sm:p-8 border-danger/20 fade-in" data-animate style="animation-delay: 0.2s;">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-danger/10 rounded-xl flex items-center justify-center mr-4">
                    <x-icons.trash class="w-5 h-5 sm:w-6 sm:h-6 text-danger" />
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-semibold text-danger">Excluir Conta</h2>
                    <p class="text-sm text-primary-600 dark:text-primary-400">Uma vez que sua conta for excluída, todos os recursos e dados serão permanentemente deletados</p>
                </div>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
