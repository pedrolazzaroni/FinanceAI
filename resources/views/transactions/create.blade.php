<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-apple-gray-900">
                Nova Transação
            </h1>
            <a href="{{ route('transactions.index') }}" class="btn-secondary">
                <x-icons.arrow-down class="w-4 h-4 mr-2 rotate-90" />
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-minimal">
            <div class="p-8">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf
                    
                    <!-- Tipo de Transação -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-primary-700 dark:text-primary-300 mb-4">
                            Tipo de Transação
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-6 border-2 border-apple-gray-200 rounded-xl cursor-pointer hover:bg-apple-gray-50 hover:border-emerald-300 transition-all duration-200 group">
                                <input type="radio" name="type" value="income" class="sr-only" {{ old('type') === 'income' ? 'checked' : '' }}>
                                <div class="flex items-center space-x-4 w-full">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                        <x-icons.trending-up class="w-6 h-6 text-emerald-600" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-apple-gray-900">Receita</div>
                                        <div class="text-sm text-apple-gray-500">Dinheiro que entra</div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-6 border-2 border-apple-gray-200 rounded-xl cursor-pointer hover:bg-apple-gray-50 hover:border-red-300 transition-all duration-200 group">
                                <input type="radio" name="type" value="expense" class="sr-only" {{ old('type') === 'expense' ? 'checked' : '' }}>
                                <div class="flex items-center space-x-4 w-full">
                                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:bg-red-200 transition-colors">
                                        <x-icons.trending-down class="w-6 h-6 text-red-600" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-apple-gray-900">Gasto</div>
                                        <div class="text-sm text-apple-gray-500">Dinheiro que sai</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoria -->
                    <div class="mb-6">
                        <label for="category_id" class="block text-sm font-medium text-apple-gray-700 mb-2">
                            Categoria
                        </label>
                        <select name="category_id" id="category_id" 
                                class="block w-full rounded-xl border-apple-gray-200 bg-white text-apple-gray-900 focus:border-apple-gray-400 focus:ring-apple-gray-400">
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
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor -->
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-medium text-apple-gray-700 mb-2">
                            Valor (R$)
                        </label>
                        <input type="number" name="amount" id="amount" step="0.01" min="0.01" 
                               value="{{ old('amount') }}"
                               class="block w-full rounded-xl border-apple-gray-200 bg-white text-apple-gray-900 focus:border-apple-gray-400 focus:ring-apple-gray-400"
                               placeholder="0,00">
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-apple-gray-700 mb-2">
                            Descrição
                        </label>
                        <input type="text" name="description" id="description" 
                               value="{{ old('description') }}"
                               class="block w-full rounded-xl border-apple-gray-200 bg-white text-apple-gray-900 focus:border-apple-gray-400 focus:ring-apple-gray-400"
                               placeholder="Ex: Compra no supermercado">
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data da Transação -->
                    <div class="mb-6">
                        <label for="transaction_date" class="block text-sm font-medium text-apple-gray-700 mb-2">
                            Data da Transação
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date" 
                               value="{{ old('transaction_date', date('Y-m-d')) }}"
                               class="block w-full rounded-xl border-apple-gray-200 bg-white text-apple-gray-900 focus:border-apple-gray-400 focus:ring-apple-gray-400">
                        @error('transaction_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observações -->
                    <div class="mb-8">
                        <label for="notes" class="block text-sm font-medium text-apple-gray-700 mb-2">
                            Observações (opcional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="block w-full rounded-xl border-apple-gray-200 bg-white text-apple-gray-900 focus:border-apple-gray-400 focus:ring-apple-gray-400"
                                  placeholder="Informações adicionais sobre a transação">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('transactions.index') }}" class="btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            Salvar Transação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Filtrar categorias baseado no tipo selecionado
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const categorySelect = document.getElementById('category_id');
            const categoryOptions = Array.from(categorySelect.options);

            // Adicionar evento de clique para os labels dos tipos de transação
            const typeLabels = document.querySelectorAll('label:has(input[name="type"])');
            
            typeLabels.forEach(label => {
                const radio = label.querySelector('input[name="type"]');
                
                label.addEventListener('click', function() {
                    // Remove seleção visual de todos
                    typeLabels.forEach(l => l.classList.remove('border-emerald-400', 'border-red-400', 'bg-emerald-50', 'bg-red-50'));
                    
                    // Adiciona seleção visual ao clicado
                    if (radio.value === 'income') {
                        label.classList.add('border-emerald-400', 'bg-emerald-50');
                    } else {
                        label.classList.add('border-red-400', 'bg-red-50');
                    }
                    
                    radio.checked = true;
                    filterCategories();
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

            // Configurar estado inicial se já houver um tipo selecionado
            const checkedType = document.querySelector('input[name="type"]:checked');
            if (checkedType) {
                const checkedLabel = checkedType.closest('label');
                if (checkedType.value === 'income') {
                    checkedLabel.classList.add('border-emerald-400', 'bg-emerald-50');
                } else {
                    checkedLabel.classList.add('border-red-400', 'bg-red-50');
                }
                filterCategories();
            }
        });
    </script>
</x-app-layout>