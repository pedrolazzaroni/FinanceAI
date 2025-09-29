<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    Editar Transação
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Modifique os dados da sua transação financeira
                </p>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn-secondary hover-lift">
                <x-icons.arrow-down class="w-4 h-4 mr-2 rotate-90" />
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-minimal slide-up">
            <div class="p-8">
                <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Tipo de Transação -->
                    <div class="mb-8">
                        <label class="form-label">
                            Tipo de Transação
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-6 border-2 border-primary-200 dark:border-primary-700 rounded-xl cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800 hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-200 group type-option">
                                <input type="radio" name="type" value="income" class="sr-only" {{ old('type', $transaction->type) === 'income' ? 'checked' : '' }}>
                                <div class="flex items-center space-x-4 w-full">
                                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors">
                                        <x-icons.trending-up class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-primary-900 dark:text-primary-100">Receita</div>
                                        <div class="text-sm text-primary-500 dark:text-primary-400">Dinheiro que entra</div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-6 border-2 border-primary-200 dark:border-primary-700 rounded-xl cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800 hover:border-red-300 dark:hover:border-red-600 transition-all duration-200 group type-option">
                                <input type="radio" name="type" value="expense" class="sr-only" {{ old('type', $transaction->type) === 'expense' ? 'checked' : '' }}>
                                <div class="flex items-center space-x-4 w-full">
                                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center group-hover:bg-red-200 dark:group-hover:bg-red-900/50 transition-colors">
                                        <x-icons.trending-down class="w-6 h-6 text-red-600 dark:text-red-400" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-primary-900 dark:text-primary-100">Gasto</div>
                                        <div class="text-sm text-primary-500 dark:text-primary-400">Dinheiro que sai</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoria -->
                    <div class="mb-6">
                        <label for="category_id" class="form-label">
                            Categoria
                        </label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        data-type="{{ $category->type }}"
                                        {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor -->
                    <div class="mb-6">
                        <label for="amount" class="form-label">
                            Valor (R$)
                        </label>
                        <input type="number" name="amount" id="amount" step="0.01" min="0.01" 
                               value="{{ old('amount', $transaction->amount) }}"
                               class="form-input"
                               placeholder="0,00">
                        @error('amount')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="mb-6">
                        <label for="description" class="form-label">
                            Descrição
                        </label>
                        <input type="text" name="description" id="description" 
                               value="{{ old('description', $transaction->description) }}"
                               class="form-input"
                               placeholder="Ex: Compra no supermercado">
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data da Transação -->
                    <div class="mb-6">
                        <label for="transaction_date" class="form-label">
                            Data da Transação
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date" 
                               value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                               class="form-input">
                        @error('transaction_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observações -->
                    <div class="mb-8">
                        <label for="notes" class="form-label">
                            Observações (opcional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-textarea"
                                  placeholder="Informações adicionais sobre a transação">{{ old('notes', $transaction->notes) }}</textarea>
                        @error('notes')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('transactions.index') }}" class="btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            <x-icons.edit class="w-4 h-4 mr-2" />
                            Atualizar Transação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const categorySelect = document.getElementById('category_id');
            const categoryOptions = Array.from(categorySelect.options);
            const typeLabels = document.querySelectorAll('.type-option');
            
            // Adicionar evento de clique para os labels dos tipos de transação
            typeLabels.forEach(label => {
                const radio = label.querySelector('input[name="type"]');
                
                label.addEventListener('click', function() {
                    // Remove seleção visual de todos
                    typeLabels.forEach(l => {
                        l.classList.remove('border-emerald-400', 'border-red-400', 'bg-emerald-50', 'bg-red-50');
                        l.classList.remove('dark:border-emerald-500', 'dark:border-red-500', 'dark:bg-emerald-900/20', 'dark:bg-red-900/20');
                    });
                    
                    // Adiciona seleção visual ao clicado
                    if (radio.value === 'income') {
                        label.classList.add('border-emerald-400', 'bg-emerald-50', 'dark:border-emerald-500', 'dark:bg-emerald-900/20');
                    } else {
                        label.classList.add('border-red-400', 'bg-red-50', 'dark:border-red-500', 'dark:bg-red-900/20');
                    }
                    
                    radio.checked = true;
                    filterCategories();
                });
            });

            function filterCategories() {
                const selectedType = document.querySelector('input[name="type"]:checked')?.value;
                const currentValue = categorySelect.value;
                
                // Limpa o select
                categorySelect.innerHTML = '<option value="">Selecione uma categoria</option>';
                
                // Adiciona apenas as categorias do tipo selecionado
                categoryOptions.forEach(option => {
                    if (option.value === '') return;
                    const optionType = option.dataset.type;
                    if (!selectedType || optionType === selectedType) {
                        const newOption = option.cloneNode(true);
                        categorySelect.appendChild(newOption);
                        
                        // Restaura a seleção se ainda for válida
                        if (option.value === currentValue) {
                            categorySelect.value = currentValue;
                        }
                    }
                });
            }

            // Configurar estado inicial se já houver um tipo selecionado
            const checkedType = document.querySelector('input[name="type"]:checked');
            if (checkedType) {
                const checkedLabel = checkedType.closest('.type-option');
                if (checkedType.value === 'income') {
                    checkedLabel.classList.add('border-emerald-400', 'bg-emerald-50', 'dark:border-emerald-500', 'dark:bg-emerald-900/20');
                } else {
                    checkedLabel.classList.add('border-red-400', 'bg-red-50', 'dark:border-red-500', 'dark:bg-red-900/20');
                }
                filterCategories();
            }
        });
    </script>
</x-app-layout>