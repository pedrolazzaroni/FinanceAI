<!-- Modal de Nova Transação -->
<div id="transaction-modal" class="modal hidden">
    <div class="modal-backdrop" onclick="window.modalManager.close('transaction-modal')"></div>
    <div class="modal-content">
        <div class="p-4 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg sm:text-xl font-semibold text-primary-950 dark:text-primary-50">Nova Transação</h2>
                <button onclick="window.modalManager.close('transaction-modal')" class="btn-icon p-2">
                    <x-icons.x class="w-4 h-4" />
                </button>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Tipo de Transação -->
                <div class="space-y-3">
                    <label class="form-label">Tipo de Transação</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="transaction-type-option flex items-center p-3 border-2 border-primary-200 dark:border-primary-700 rounded-lg cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all">
                            <input type="radio" name="type" value="income" class="sr-only">
                            <div class="flex items-center gap-3 w-full">
                                <div class="w-8 h-8 bg-success/15 rounded-lg flex items-center justify-center">
                                    <x-icons.trending-up class="w-4 h-4 text-success" />
                                </div>
                                <div>
                                    <div class="font-medium text-primary-950 dark:text-primary-50 text-sm">Receita</div>
                                    <div class="text-xs text-primary-500 dark:text-primary-400">Dinheiro que entra</div>
                                </div>
                            </div>
                        </label>

                        <label class="transaction-type-option flex items-center p-3 border-2 border-primary-200 dark:border-primary-700 rounded-lg cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all">
                            <input type="radio" name="type" value="expense" class="sr-only">
                            <div class="flex items-center gap-3 w-full">
                                <div class="w-8 h-8 bg-danger/15 rounded-lg flex items-center justify-center">
                                    <x-icons.trending-down class="w-4 h-4 text-danger" />
                                </div>
                                <div>
                                    <div class="font-medium text-primary-950 dark:text-primary-50 text-sm">Gasto</div>
                                    <div class="text-xs text-primary-500 dark:text-primary-400">Dinheiro que sai</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Categoria -->
                <div class="space-y-2">
                    <label for="category_id" class="form-label">Categoria</label>
                    <select name="category_id" id="modal_category_id" class="form-select">
                        <option value="">Selecione uma categoria</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-type="{{ $category->type }}">{{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Valor e Descrição -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="amount" class="form-label">Valor</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400 text-sm">R$</span>
                            <input type="number" name="amount" step="0.01" min="0.01" placeholder="0,00" class="form-input pl-10" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" name="description" placeholder="Ex: Compra no supermercado" class="form-input" required>
                    </div>
                </div>

                <!-- Data -->
                <div class="space-y-2">
                    <label for="transaction_date" class="form-label">Data da Transação</label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>

                <!-- Observações -->
                <div class="space-y-2">
                    <label for="notes" class="form-label">Observações (opcional)</label>
                    <textarea name="notes" rows="2" placeholder="Informações adicionais..." class="form-textarea"></textarea>
                </div>

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">Salvar Transação</button>
                    <button type="button" onclick="window.modalManager.close('transaction-modal')" class="btn-secondary px-6">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script para modal de transação
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica para filtrar categorias no modal de transação
        const typeLabels = document.querySelectorAll('#transaction-modal .transaction-type-option');
        const categorySelect = document.getElementById('modal_category_id');

        if (categorySelect) {
            const categoryOptions = Array.from(categorySelect.options);

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
                    filterModalCategories();
                });
            });

            function filterModalCategories() {
                const selectedType = document.querySelector('#transaction-modal input[name="type"]:checked')?.value;

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
        }
    });
</script>
