<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between fade-in">
            <div>
                <h1 class="text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    Nova Meta Financeira
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Defina um objetivo claro para alcançar seus sonhos financeiros
                </p>
            </div>
            <a href="{{ route('goals.index') }}" class="btn-secondary hover-lift gap-2">
                <x-icons.arrow-left class="w-4 h-4" />
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-minimal p-8 fade-in" data-animate>
            <form action="{{ route('goals.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nome da Meta -->
                <div class="space-y-2">
                    <label for="name" class="form-label">Nome da Meta</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
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
                              class="form-textarea transition-all duration-200 focus:scale-[1.02]">{{ old('description') }}</textarea>
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
                                   value="{{ old('target_amount') }}"
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
                            <option value="savings" {{ old('type') === 'savings' ? 'selected' : '' }}>Poupança</option>
                            <option value="expense_reduction" {{ old('type') === 'expense_reduction' ? 'selected' : '' }}>Redução de Gastos</option>
                            <option value="income_increase" {{ old('type') === 'income_increase' ? 'selected' : '' }}>Aumento de Renda</option>
                        </select>
                        @error('type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Grid para valor atual e data -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Valor Atual -->
                    <div class="space-y-2">
                        <label for="current_amount" class="form-label">Valor Atual (opcional)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400">R$</span>
                            <input type="number" 
                                   id="current_amount" 
                                   name="current_amount" 
                                   value="{{ old('current_amount', '0') }}"
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
                               value="{{ old('target_date') }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="form-input transition-all duration-200 focus:scale-[1.02]" 
                               required>
                        @error('target_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informações sobre tipos de meta -->
                <div class="bg-primary-50/50 dark:bg-primary-800/30 rounded-xl p-4 fade-in" data-animate style="animation-delay: 0.2s;">
                    <h4 class="font-semibold text-primary-950 dark:text-primary-50 mb-3">Tipos de Meta:</h4>
                    <div class="space-y-2 text-sm text-primary-600 dark:text-primary-400">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-info rounded-full mt-2"></div>
                            <div>
                                <strong>Poupança:</strong> Para juntar dinheiro (ex: reserva de emergência, compra de casa)
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-danger rounded-full mt-2"></div>
                            <div>
                                <strong>Redução de Gastos:</strong> Para diminuir despesas mensais
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-success rounded-full mt-2"></div>
                            <div>
                                <strong>Aumento de Renda:</strong> Para aumentar ganhos mensais
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn-primary w-full sm:w-auto hover-lift gap-2">
                        <x-icons.target class="w-4 h-4" />
                        Criar Meta
                    </button>
                    <a href="{{ route('goals.index') }}" class="btn-secondary w-full sm:w-auto text-center hover-lift">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Preview da Meta -->
        <div class="mt-8 card-minimal p-6 fade-in" data-animate style="animation-delay: 0.3s;">
            <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50 mb-4">Preview da Meta</h3>
            <div class="goal-preview space-y-4 opacity-50">
                <div>
                    <h4 class="font-semibold text-primary-900 dark:text-primary-100" id="preview-name">Nome da Meta</h4>
                    <p class="text-sm text-primary-600 dark:text-primary-400" id="preview-description">Descrição da meta</p>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-primary-900 dark:text-primary-100" id="preview-current">R$ 0,00</span>
                    <span class="text-lg font-semibold" id="preview-percentage">0%</span>
                </div>
                <div class="w-full bg-primary-100 dark:bg-primary-800 rounded-full h-3">
                    <div class="bg-gradient-to-r from-success to-success/80 h-3 rounded-full transition-all duration-500" 
                         style="width: 0%;" id="preview-progress"></div>
                </div>
                <div class="flex justify-between text-sm text-primary-600 dark:text-primary-400">
                    <span id="preview-current-text">Atual: R$ 0,00</span>
                    <span id="preview-target">Meta: R$ 0,00</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const descriptionInput = document.getElementById('description');
            const targetAmountInput = document.getElementById('target_amount');
            const currentAmountInput = document.getElementById('current_amount');
            
            const previewName = document.getElementById('preview-name');
            const previewDescription = document.getElementById('preview-description');
            const previewCurrent = document.getElementById('preview-current');
            const previewTarget = document.getElementById('preview-target');
            const previewCurrentText = document.getElementById('preview-current-text');
            const previewPercentage = document.getElementById('preview-percentage');
            const previewProgress = document.getElementById('preview-progress');
            const goalPreview = document.querySelector('.goal-preview');

            function updatePreview() {
                const name = nameInput.value || 'Nome da Meta';
                const description = descriptionInput.value || 'Descrição da meta';
                const targetAmount = parseFloat(targetAmountInput.value) || 0;
                const currentAmount = parseFloat(currentAmountInput.value) || 0;
                
                previewName.textContent = name;
                previewDescription.textContent = description;
                
                const formattedCurrent = currentAmount.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
                const formattedTarget = targetAmount.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
                
                previewCurrent.textContent = formattedCurrent;
                previewTarget.textContent = `Meta: ${formattedTarget}`;
                previewCurrentText.textContent = `Atual: ${formattedCurrent}`;
                
                const percentage = targetAmount > 0 ? Math.min((currentAmount / targetAmount) * 100, 100) : 0;
                previewPercentage.textContent = `${percentage.toFixed(1)}%`;
                previewProgress.style.width = `${percentage}%`;
                
                // Reduzir opacidade se não há dados
                if (name === 'Nome da Meta' && targetAmount === 0) {
                    goalPreview.classList.add('opacity-50');
                } else {
                    goalPreview.classList.remove('opacity-50');
                }
            }

            nameInput.addEventListener('input', updatePreview);
            descriptionInput.addEventListener('input', updatePreview);
            targetAmountInput.addEventListener('input', updatePreview);
            currentAmountInput.addEventListener('input', updatePreview);
        });
    </script>
</x-app-layout>