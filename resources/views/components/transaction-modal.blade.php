@props(['categories'])

<div id="transaction-modal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="text-xl font-semibold text-primary-950 dark:text-primary-50">Nova Transação</h2>
            <button type="button" onclick="window.modalManager.close('transaction-modal')" class="modal-close-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="transaction-form" method="POST" action="{{ route('transactions.store') }}" class="modal-body space-y-6">
            @csrf
            
            <!-- Tipo de Transação -->
            <div class="space-y-4">
                <label class="form-label">Tipo de Transação</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="transaction-type-option flex items-center p-4 border-2 border-primary-200 dark:border-primary-700 rounded-xl cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800/50 hover:border-success/50 transition-all duration-200 group">
                        <input type="radio" name="type" value="income" class="sr-only">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-10 h-10 bg-success/15 rounded-xl flex items-center justify-center group-hover:bg-success/25 transition-colors">
                                <x-icons.trending-up class="w-5 h-5 text-success" />
                            </div>
                            <div>
                                <div class="font-semibold text-primary-950 dark:text-primary-50">Receita</div>
                                <div class="text-sm text-primary-500 dark:text-primary-400">Dinheiro que entra</div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="transaction-type-option flex items-center p-4 border-2 border-primary-200 dark:border-primary-700 rounded-xl cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-800/50 hover:border-danger/50 transition-all duration-200 group">
                        <input type="radio" name="type" value="expense" class="sr-only">
                        <div class="flex items-center space-x-3 w-full">
                            <div class="w-10 h-10 bg-danger/15 rounded-xl flex items-center justify-center group-hover:bg-danger/25 transition-colors">
                                <x-icons.trending-down class="w-5 h-5 text-danger" />
                            </div>
                            <div>
                                <div class="font-semibold text-primary-950 dark:text-primary-50">Gasto</div>
                                <div class="text-sm text-primary-500 dark:text-primary-400">Dinheiro que sai</div>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="form-error" id="type-error" style="display: none;"></div>
            </div>

            <!-- Grid responsivo para campos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Categoria -->
                <div class="space-y-2">
                    <label for="modal-category_id" class="form-label">Categoria</label>
                    <select name="category_id" id="modal-category_id" class="form-select transition-all duration-200 focus:scale-[1.02]">
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-type="{{ $category->type }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-error" id="category-error" style="display: none;"></div>
                </div>

                <!-- Valor -->
                <div class="space-y-2">
                    <label for="modal-amount" class="form-label">Valor</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400">R$</span>
                        <input type="number" name="amount" id="modal-amount" step="0.01" min="0.01" 
                               class="form-input pl-12 transition-all duration-200 focus:scale-[1.02]"
                               placeholder="0,00">
                    </div>
                    <div class="form-error" id="amount-error" style="display: none;"></div>
                </div>
            </div>

            <!-- Descrição e Data -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Descrição -->
                <div class="space-y-2">
                    <label for="modal-description" class="form-label">Descrição</label>
                    <input type="text" name="description" id="modal-description" 
                           class="form-input transition-all duration-200 focus:scale-[1.02]"
                           placeholder="Ex: Compra no supermercado">
                    <div class="form-error" id="description-error" style="display: none;"></div>
                </div>

                <!-- Data da Transação -->
                <div class="space-y-2">
                    <label for="modal-transaction_date" class="form-label">Data da Transação</label>
                    <input type="date" name="transaction_date" id="modal-transaction_date" 
                           value="{{ date('Y-m-d') }}"
                           class="form-input transition-all duration-200 focus:scale-[1.02]">
                    <div class="form-error" id="transaction-date-error" style="display: none;"></div>
                </div>
            </div>

            <!-- Observações -->
            <div class="space-y-2">
                <label for="modal-notes" class="form-label">Observações <span class="text-sm text-primary-500 dark:text-primary-400">(opcional)</span></label>
                <textarea name="notes" id="modal-notes" rows="3"
                          class="form-textarea transition-all duration-200 focus:scale-[1.02]"
                          placeholder="Informações adicionais sobre a transação"></textarea>
                <div class="form-error" id="notes-error" style="display: none;"></div>
            </div>
        </form>

        <div class="modal-footer">
            <button type="button" onclick="window.modalManager.close('transaction-modal')" class="btn-secondary">
                Cancelar
            </button>
            <button type="submit" form="transaction-form" class="btn-primary gap-2">
                <x-icons.plus class="w-4 h-4" />
                Salvar Transação
            </button>
        </div>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
}

.modal-overlay.active {
    display: flex;
}

.modal-container {
    background: white;
    border-radius: 1rem;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: scale(0.9);
    transition: transform 0.2s ease-out;
}

.modal-overlay.active .modal-container {
    transform: scale(1);
}

.dark .modal-container {
    background: rgb(31 41 55);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid rgb(229 231 235);
}

.dark .modal-header {
    border-bottom-color: rgb(75 85 99);
}

.modal-close-btn {
    padding: 0.5rem;
    border-radius: 0.5rem;
    color: rgb(107 114 128);
    transition: all 0.2s;
}

.modal-close-btn:hover {
    background: rgb(243 244 246);
    color: rgb(75 85 99);
}

.dark .modal-close-btn:hover {
    background: rgb(55 65 81);
    color: rgb(156 163 175);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    gap: 0.75rem;
    padding: 1.5rem;
    border-top: 1px solid rgb(229 231 235);
    justify-content: flex-end;
}

.dark .modal-footer {
    border-top-color: rgb(75 85 99);
}

@media (max-width: 640px) {
    .modal-footer {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transaction-form');
    const typeLabels = document.querySelectorAll('#transaction-modal .transaction-type-option');
    const categorySelect = document.getElementById('modal-category_id');
    const categoryOptions = Array.from(categorySelect.options);
    
    // Event listeners para tipos de transação
    typeLabels.forEach(label => {
        const radio = label.querySelector('input[name="type"]');
        
        label.addEventListener('click', function() {
            typeLabels.forEach(l => {
                l.classList.remove('border-success', 'border-danger', 'bg-success/5', 'bg-danger/5');
                l.classList.add('border-primary-200', 'dark:border-primary-700');
            });
            
            if (radio.value === 'income') {
                label.classList.remove('border-primary-200', 'dark:border-primary-700');
                label.classList.add('border-success', 'bg-success/5');
            } else {
                label.classList.remove('border-primary-200', 'dark:border-primary-700');
                label.classList.add('border-danger', 'bg-danger/5');
            }
            
            radio.checked = true;
            filterCategories();
        });
    });

    function filterCategories() {
        const selectedType = document.querySelector('#transaction-modal input[name="type"]:checked')?.value;
        
        categorySelect.innerHTML = '<option value="">Selecione uma categoria</option>';
        
        categoryOptions.forEach(option => {
            if (option.value === '') return;
            const optionType = option.dataset.type;
            if (!selectedType || optionType === selectedType) {
                categorySelect.appendChild(option.cloneNode(true));
            }
        });
    }

    // Submit do formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Limpar erros anteriores
        document.querySelectorAll('.form-error').forEach(error => error.style.display = 'none');
        
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.modalManager.close('transaction-modal');
                // Recarregar a página ou atualizar a lista
                window.location.reload();
            } else if (data.errors) {
                // Mostrar erros de validação
                Object.keys(data.errors).forEach(field => {
                    const errorDiv = document.getElementById(field + '-error');
                    if (errorDiv) {
                        errorDiv.textContent = data.errors[field][0];
                        errorDiv.style.display = 'block';
                    }
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar transação');
        });
    });

    // Limpar formulário quando o modal abrir
    window.modalManager.onOpen('transaction-modal', function() {
        form.reset();
        document.querySelectorAll('.form-error').forEach(error => error.style.display = 'none');
        typeLabels.forEach(l => {
            l.classList.remove('border-success', 'border-danger', 'bg-success/5', 'bg-danger/5');
            l.classList.add('border-primary-200', 'dark:border-primary-700');
        });
        categorySelect.innerHTML = '<option value="">Selecione uma categoria</option>';
        categoryOptions.forEach(option => {
            if (option.value !== '') {
                categorySelect.appendChild(option.cloneNode(true));
            }
        });
        document.getElementById('modal-transaction_date').value = new Date().toISOString().split('T')[0];
    });
});
</script>