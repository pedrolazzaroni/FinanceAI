<section class="space-y-6">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn-danger"
    >Excluir Conta</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-primary-950 dark:text-primary-50">
                Tem certeza que deseja excluir sua conta?
            </h2>

            <p class="mt-1 text-sm text-primary-600 dark:text-primary-400">
                Uma vez que sua conta for excluída, todos os recursos e dados serão permanentemente deletados. Digite sua senha para confirmar que deseja excluir permanentemente sua conta.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Senha" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="form-input w-3/4"
                    placeholder="Senha"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="form-error" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="btn-secondary">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="btn-danger">
                    Excluir Conta
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
