<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between fade-in">
            <div>
                <h1 class="text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    Editar Meta: {{ $goal->name }}
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Atualize os detalhes da sua meta financeira
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('goals.index') }}" class="btn-secondary hover-lift gap-2">
                    <x-icons.arrow-left class="w-4 h-4" />
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-minimal p-8 fade-in" data-animate>
            <form action="{{ route('goals.update', $goal) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Nome da Meta -->
                <div class="space-y-2">
                    <label for="name" class="form-label">Nome da Meta</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $goal->name) }}"
                           placeholder="Ex: Reserva de emergência, Viagem para Europa..."
                           class="form-input transition-all duration-200 focus:scale-[1.02]" 
                           required>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="space-y-2">
                    <label for="description" class="form-label">Descrição (opcional)</label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              placeholder="Descreva mais detalhes sobre sua meta..."
                              class="form-textarea transition-all duration-200 focus:scale-[1.02]">{{ old('description', $goal->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grid para valor e tipo -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Valor da Meta -->
                    <div class="space-y-2">
                        <label for="target_amount" class="form-label">Valor da Meta</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400">R$</span>
                            <input type="number" 
                                   id="target_amount" 
                                   name="target_amount" 
                                   value="{{ old('target_amount', $goal->target_amount) }}"
                                   step="0.01" 
                                   min="0.01"
                                   placeholder="0,00"
                                   class="form-input pl-12 transition-all duration-200 focus:scale-[1.02]" 
                                   required>
                        </div>
                        @error('target_amount')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Meta -->
                    <div class="space-y-2">
                        <label for="type" class="form-label">Tipo de Meta</label>
                        <select id="type" 
                                name="type" 
                                class="form-select transition-all duration-200 focus:scale-[1.02]" 
                                required>
                            <option value="">Selecione o tipo</option>
                            <option value="savings" {{ old('type', $goal->type) === 'savings' ? 'selected' : '' }}>Poupança</option>
                            <option value="expense_reduction" {{ old('type', $goal->type) === 'expense_reduction' ? 'selected' : '' }}>Redução de Gastos</option>
                            <option value="income_increase" {{ old('type', $goal->type) === 'income_increase' ? 'selected' : '' }}>Aumento de Renda</option>
                        </select>
                        @error('type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Grid para valor atual, data e status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Valor Atual -->
                    <div class="space-y-2">
                        <label for="current_amount" class="form-label">Valor Atual</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400">R$</span>
                            <input type="number" 
                                   id="current_amount" 
                                   name="current_amount" 
                                   value="{{ old('current_amount', $goal->current_amount) }}"
                                   step="0.01" 
                                   min="0"
                                   placeholder="0,00"
                                   class="form-input pl-12 transition-all duration-200 focus:scale-[1.02]">
                        </div>
                        @error('current_amount')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data Limite -->
                    <div class="space-y-2">
                        <label for="target_date" class="form-label">Data Limite</label>
                        <input type="date" 
                               id="target_date" 
                               name="target_date" 
                               value="{{ old('target_date', $goal->target_date->format('Y-m-d')) }}"
                               class="form-input transition-all duration-200 focus:scale-[1.02]" 
                               required>
                        @error('target_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" 
                                name="status" 
                                class="form-select transition-all duration-200 focus:scale-[1.02]" 
                                required>
                            <option value="active" {{ old('status', $goal->status) === 'active' ? 'selected' : '' }}>Ativa</option>
                            <option value="paused" {{ old('status', $goal->status) === 'paused' ? 'selected' : '' }}>Pausada</option>
                            <option value="completed" {{ old('status', $goal->status) === 'completed' ? 'selected' : '' }}>Concluída</option>
                        </select>
                        @error('status')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Progresso Atual -->
                <div class="bg-primary-50/50 dark:bg-primary-800/30 rounded-xl p-6 fade-in" data-animate style="animation-delay: 0.2s;">
                    <h4 class="font-semibold text-primary-950 dark:text-primary-50 mb-4">Progresso Atual</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-primary-900 dark:text-primary-100">
                                R$ {{ number_format($goal->current_amount, 2, ',', '.') }}
                            </span>
                            <span class="text-lg font-semibold">
                                {{ number_format($goal->progress_percentage, 1) }}%
                            </span>
                        </div>
                        
                        <div class="w-full bg-primary-100 dark:bg-primary-800 rounded-full h-3">
                            <div class="bg-gradient-to-r from-success to-success/80 h-3 rounded-full transition-all duration-1000" 
                                 style="width: {{ $goal->progress_percentage }}%;"></div>
                        </div>
                        
                        <div class="flex justify-between text-sm text-primary-600 dark:text-primary-400">
                            <span>Atual: R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</span>
                            <span>Meta: R$ {{ number_format($goal->target_amount, 2, ',', '.') }}</span>
                        </div>
                        
                        @if($goal->remaining_amount > 0)
                        <p class="text-sm text-primary-500 dark:text-primary-400">
                            Faltam R$ {{ number_format($goal->remaining_amount, 2, ',', '.') }} para atingir sua meta
                        </p>
                        @endif

                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="text-center">
                                <p class="text-sm text-primary-500 dark:text-primary-400">Dias restantes</p>
                                <p class="text-lg font-semibold {{ $goal->is_overdue ? 'text-danger' : 'text-primary-900 dark:text-primary-100' }}">
                                    {{ $goal->days_remaining }}
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-primary-500 dark:text-primary-400">Data limite</p>
                                <p class="text-lg font-semibold text-primary-900 dark:text-primary-100">
                                    {{ $goal->target_date->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn-primary w-full sm:w-auto hover-lift gap-2">
                        <x-icons.edit class="w-4 h-4" />
                        Atualizar Meta
                    </button>
                    <a href="{{ route('goals.index') }}" class="btn-secondary w-full sm:w-auto text-center hover-lift">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Ações Perigosas -->
        <div class="mt-8 card-minimal p-6 border border-red-200 dark:border-red-800 fade-in" data-animate style="animation-delay: 0.3s;">
            <h3 class="text-lg font-semibold text-danger mb-4">Zona de Perigo</h3>
            <p class="text-sm text-primary-600 dark:text-primary-400 mb-4">
                A exclusão de uma meta é permanente e não pode ser desfeita.
            </p>
            <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn-danger gap-2 hover-lift"
                        onclick="return confirm('Tem certeza de que deseja excluir esta meta? Esta ação não pode ser desfeita.')">
                    <x-icons.trash class="w-4 h-4" />
                    Excluir Meta
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Atualizar progresso em tempo real quando o usuário digita
            const currentAmountInput = document.getElementById('current_amount');
            const targetAmountInput = document.getElementById('target_amount');
            
            function updateProgress() {
                const current = parseFloat(currentAmountInput.value) || 0;
                const target = parseFloat(targetAmountInput.value) || 0;
                
                if (target > 0) {
                    const percentage = Math.min((current / target) * 100, 100);
                    // Aqui você pode atualizar o visual do progresso se quiser
                }
            }
            
            currentAmountInput.addEventListener('input', updateProgress);
            targetAmountInput.addEventListener('input', updateProgress);
        });
    </script>
</x-app-layout>