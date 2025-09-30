<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 fade-in">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    Nova Transação
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Registre uma nova receita ou despesa
                </p>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn-secondary hover-lift gap-2">
                <x-icons.arrow-left class="w-4 h-4" />
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-minimal p-6 sm:p-8 fade-in" data-animate>
            <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
                @csrf
                
                <!-- Tipo de Transação -->
                <div class="space-y-4">
                    <label class="form-label">
                        Tipo de Transação
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="transaction-type-option flex items-center p-4 sm:p-6 border-2 border-primary-200 dark:border-primary-700 rounded-xl cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800/50 hover:border-success/50 transition-all duration-200 group">
                            <input type="radio" name="type" value="income" class="sr-only" {{ old('type') === 'income' ? 'checked' : '' }}>
                            <div class="flex items-center space-x-3 sm:space-x-4 w-full">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-success/15 rounded-xl flex items-center justify-center group-hover:bg-success/25 transition-colors">
                                    <x-icons.trending-up class="w-5 h-5 sm:w-6 sm:h-6 text-success" />
                                </div>
                                <div>
                                    <div class="font-semibold text-primary-950 dark:text-primary-50">Receita</div>
                                    <div class="text-sm text-primary-500 dark:text-primary-400">Dinheiro que entra</div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="transaction-type-option flex items-center p-4 sm:p-6 border-2 border-primary-200 dark:border-primary-700 rounded-xl cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800/50 hover:border-danger/50 transition-all duration-200 group">
                            <input type="radio" name="type" value="expense" class="sr-only" {{ old('type') === 'expense' ? 'checked' : '' }}>
                            <div class="flex items-center space-x-3 sm:space-x-4 w-full">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-danger/15 rounded-xl flex items-center justify-center group-hover:bg-danger/25 transition-colors">
                                    <x-icons.trending-down class="w-5 h-5 sm:w-6 sm:h-6 text-danger" />
                                </div>
                                <div>
                                    <div class="font-semibold text-primary-950 dark:text-primary-50">Gasto</div>
                                    <div class="text-sm text-primary-500 dark:text-primary-400">Dinheiro que sai</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grid responsivo para campos -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Categoria -->
                    <div class="space-y-2">
                        <label for="category_id" class="form-label">
                            Categoria
                        </label>
                        <select name="category_id" id="category_id" 
                                class="form-select transition-all duration-200 focus:scale-[1.02]">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        data-type="{{ $category->type }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor -->
                    <div class="space-y-2">
                        <label for="amount" class="form-label">
                            Valor
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400">R$</span>
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01" 
                                   value="{{ old('amount') }}"
                                   class="form-input pl-12 transition-all duration-200 focus:scale-[1.02]"
                                   placeholder="0,00">
                        </div>
                        @error('amount')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Descrição e Data -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Descrição -->
                    <div class="space-y-2">
                        <label for="description" class="form-label">
                            Descrição
                        </label>
                        <input type="text" name="description" id="description" 
                               value="{{ old('description') }}"
                               class="form-input transition-all duration-200 focus:scale-[1.02]"
                               placeholder="Ex: Compra no supermercado">
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data da Transação -->
                    <div class="space-y-2">
                        <label for="transaction_date" class="form-label">
                            Data da Transação
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date" 
                               value="{{ old('transaction_date', date('Y-m-d')) }}"
                               class="form-input transition-all duration-200 focus:scale-[1.02]">
                        @error('transaction_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Observações -->
                <div class="space-y-2">
                    <label for="notes" class="form-label">
                        Observações <span class="text-sm text-primary-500 dark:text-primary-400">(opcional)</span>
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="form-textarea transition-all duration-200 focus:scale-[1.02]"
                              placeholder="Informações adicionais sobre a transação">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn-primary w-full sm:w-auto hover-lift gap-2">
                        <x-icons.plus class="w-4 h-4" />
                        Salvar Transação
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn-secondary w-full sm:w-auto text-center hover-lift">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Preview da Transação -->
        <div class="mt-6 sm:mt-8 card-minimal p-6 fade-in" data-animate style="animation-delay: 0.2s;">
            <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50 mb-4">Preview da Transação</h3>
            <div class="transaction-preview opacity-50 transition-opacity duration-300">
                <div class="flex items-center justify-between p-4 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-700 rounded-xl grid place-items-center mr-4">
                            <x-icons.money class="w-6 h-6 text-primary-600 dark:text-primary-300" id="preview-icon" />
                        </div>
                        <div>
                            <div class="font-semibold text-primary-950 dark:text-primary-50" id="preview-description">
                                Descrição da transação
                            </div>
                            <div class="text-sm text-primary-500 dark:text-primary-400">
                                <span id="preview-category">Categoria</span> • <span id="preview-date">{{ date('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="font-bold text-lg text-primary-600 dark:text-primary-400" id="preview-amount">
                        R$ 0,00
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeLabels = document.querySelectorAll('.transaction-type-option');
            const categorySelect = document.getElementById('category_id');
            const categoryOptions = Array.from(categorySelect.options);
            
            // Elementos do preview
            const previewIcon = document.getElementById('preview-icon');
            const previewDescription = document.getElementById('preview-description');
            const previewCategory = document.getElementById('preview-category');
            const previewDate = document.getElementById('preview-date');
            const previewAmount = document.getElementById('preview-amount');
            const previewContainer = document.querySelector('.transaction-preview');
            
            // Inputs
            const descriptionInput = document.getElementById('description');
            const amountInput = document.getElementById('amount');
            const dateInput = document.getElementById('transaction_date');
            
            // Adicionar evento de clique para os labels dos tipos de transação
            typeLabels.forEach(label => {
                const radio = label.querySelector('input[name="type"]');
                
                label.addEventListener('click', function() {
                    // Remove seleção visual de todos
                    typeLabels.forEach(l => {
                        l.classList.remove('border-success', 'border-danger', 'bg-success/5', 'bg-danger/5');
                        l.classList.add('border-primary-200', 'dark:border-primary-700');
                    });
                    
                    // Adiciona seleção visual ao clicado
                    if (radio.value === 'income') {
                        label.classList.remove('border-primary-200', 'dark:border-primary-700');
                        label.classList.add('border-success', 'bg-success/5');
                    } else {
                        label.classList.remove('border-primary-200', 'dark:border-primary-700');
                        label.classList.add('border-danger', 'bg-danger/5');
                    }
                    
                    radio.checked = true;
                    filterCategories();
                    updatePreview();
                });
            });

            function filterCategories() {
                const selectedType = document.querySelector('input[name="type"]:checked')?.value;
                
                // Limpa o select
                categorySelect.innerHTML = '<option value="">Selecione uma categoria</option>';
                
                // Adiciona apenas as categorias do tipo selecionado
                categoryOptions.forEach(option => {
                    if (option.value === '') return;
                    const optionType = option.dataset.type;
                    if (!selectedType || optionType === selectedType) {
                        categorySelect.appendChild(option.cloneNode(true));
                    }
                });
            }

            function updatePreview() {
                const selectedType = document.querySelector('input[name="type"]:checked')?.value;
                const description = descriptionInput.value || 'Descrição da transação';
                const amount = amountInput.value ? parseFloat(amountInput.value) : 0;
                const categoryText = categorySelect.options[categorySelect.selectedIndex]?.text || 'Categoria';
                const date = dateInput.value ? new Date(dateInput.value).toLocaleDateString('pt-BR') : new Date().toLocaleDateString('pt-BR');
                
                // Atualizar ícone e cor
                if (selectedType === 'income') {
                    previewIcon.className = 'w-6 h-6 text-success';
                    previewIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 010 16.986L21.75 18" />';
                    previewAmount.className = 'font-bold text-lg text-success';
                    previewAmount.textContent = `+R$ ${amount.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
                } else if (selectedType === 'expense') {
                    previewIcon.className = 'w-6 h-6 text-danger';
                    previewIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.511l-5.511-3.182" />';
                    previewAmount.className = 'font-bold text-lg text-danger';
                    previewAmount.textContent = `-R$ ${amount.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
                } else {
                    previewIcon.className = 'w-6 h-6 text-primary-600 dark:text-primary-300';
                    previewAmount.className = 'font-bold text-lg text-primary-600 dark:text-primary-400';
                    previewAmount.textContent = `R$ ${amount.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
                }
                
                previewDescription.textContent = description;
                previewCategory.textContent = categoryText;
                previewDate.textContent = date;
                
                // Controlar opacidade
                if (description === 'Descrição da transação' && amount === 0 && !selectedType) {
                    previewContainer.classList.add('opacity-50');
                } else {
                    previewContainer.classList.remove('opacity-50');
                }
            }

            // Event listeners para atualizar preview
            descriptionInput.addEventListener('input', updatePreview);
            amountInput.addEventListener('input', updatePreview);
            categorySelect.addEventListener('change', updatePreview);
            dateInput.addEventListener('change', updatePreview);

            // Configurar estado inicial se já houver um tipo selecionado
            const checkedType = document.querySelector('input[name="type"]:checked');
            if (checkedType) {
                const checkedLabel = checkedType.closest('.transaction-type-option');
                if (checkedType.value === 'income') {
                    checkedLabel.classList.add('border-success', 'bg-success/5');
                } else {
                    checkedLabel.classList.add('border-danger', 'bg-danger/5');
                }
                filterCategories();
                updatePreview();
            }
        });
    </script>
</x-app-layout>