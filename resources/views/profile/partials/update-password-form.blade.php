<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Senha Atual" class="form-label" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-input w-full mt-1" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="form-error" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nova Senha" class="form-label" />
            <x-text-input id="update_password_password" name="password" type="password" class="form-input w-full mt-1" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="form-error" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar Nova Senha" class="form-label" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input w-full mt-1" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="form-error" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn-primary">Salvar</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success"
                >Senha atualizada com sucesso!</p>
            @endif
        </div>
    </form>
</section>
