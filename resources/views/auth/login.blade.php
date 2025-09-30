<x-auth-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-primary-950 dark:text-primary-50">
                Faça login
            </h1>
            <p class="mt-2 text-sm text-primary-600 dark:text-primary-400">
                Acesse sua conta para gerenciar suas finanças
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email" class="form-label" />
                <x-text-input id="email" 
                    class="form-input w-full mt-1" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="seu@email.com" />
                <x-input-error :messages="$errors->get('email')" class="form-error" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="Senha" class="form-label" />
                <div class="relative mt-1">
                    <x-text-input id="password" 
                        class="form-input w-full pr-10"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••" />
                    <button type="button" 
                        onclick="togglePassword()" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-primary-400 hover:text-primary-600 dark:text-primary-500 dark:hover:text-primary-300 transition-colors">
                        <x-icons.eye class="w-4 h-4" id="password-eye" />
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="form-error" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" 
                        type="checkbox" 
                        class="rounded border-primary-300 dark:border-primary-600 text-primary-600 shadow-sm focus:ring-primary-300 dark:focus:ring-primary-600" 
                        name="remember">
                    <span class="ml-2 text-sm text-primary-600 dark:text-primary-400">
                        Lembrar de mim
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200 font-medium transition-colors" 
                        href="{{ route('password.request') }}">
                        Esqueceu a senha?
                    </a>
                @endif
            </div>

            <div class="space-y-3">
                <x-primary-button class="w-full justify-center">
                    Entrar
                </x-primary-button>

                <div class="text-center">
                    <span class="text-sm text-primary-600 dark:text-primary-400">Não tem uma conta?</span>
                    <a href="{{ route('register') }}" 
                        class="text-sm font-medium text-primary-900 hover:text-primary-700 dark:text-primary-100 dark:hover:text-primary-300 transition-colors ml-1">
                        Criar conta
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordEye = document.getElementById('password-eye');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordEye.innerHTML = '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88"/>';
            } else {
                passwordInput.type = 'password';
                passwordEye.innerHTML = '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
</x-auth-layout>
