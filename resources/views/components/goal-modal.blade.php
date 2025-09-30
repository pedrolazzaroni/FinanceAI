<div id="goal-modal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="text-xl font-semibold text-primary-950 dark:text-primary-50">Nova Meta Financeira</h2>
            <button type="button" onclick="window.modalManager.close('goal-modal')" class="modal-close-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="goal-form" method="POST" action="{{ route('goals.store') }}" class="modal-body space-y-6">
            @csrf

            <!-- Nome da Meta -->
            <div class="space-y-2">
                <label for="goal-name" class="form-label">Nome da Meta</label>
                <input type="text" 
                       id="goal-name" 
                       name="name" 
                       placeholder="Ex: Reserva de emergência, Viagem para Europa..."
                       class="form-input transition-all duration-200 focus:scale-[1.02]" 
                       required>
                <div class="form-error" id="name-error" style="display: none;"></div>
            </div>

            <!-- Descrição -->
            <div class="space-y-2">
                <label for="goal-description" class="form-label">Descrição (opcional)</label>
                <textarea id="goal-description" 
                          name="description" 
                          rows="3"
                          placeholder="Descreva mais detalhes sobre sua meta..."
                          class="form-textarea transition-all duration-200 focus:scale-[1.02]"></textarea>
                <div class="form-error" id="description-error" style="display: none;"></div>
            </div>

            <!-- Grid para valor e tipo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Valor da Meta -->
                <div class="space-y-2">
                    <label for="goal-target_amount" class="form-label">Valor da Meta</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400">R$</span>
                        <input type="number" 
                               id="goal-target_amount" 
                               name="target_amount" 
                               step="0.01" 
                               min="0.01"
                               placeholder="0,00"
                               class="form-input pl-12 transition-all duration-200 focus:scale-[1.02]" 
                               required>
                    </div>
                    <div class="form-error" id="target-amount-error" style="display: none;"></div>
                </div>

                <!-- Tipo de Meta -->
                <div class="space-y-2">
                    <label for="goal-type" class="form-label">Tipo de Meta</label>
                    <select id="goal-type" 
                            name="type" 
                            class="form-select transition-all duration-200 focus:scale-[1.02]" 
                            required>
                        <option value="">Selecione o tipo</option>
                        <option value="savings">Poupança</option>
                        <option value="expense_reduction">Redução de Gastos</option>
                        <option value="income_increase">Aumento de Renda</option>
                    </select>
                    <div class="form-error" id="type-error" style="display: none;"></div>
                </div>
            </div>

            <!-- Grid para valor atual e data -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Valor Atual -->
                <div class="space-y-2">
                    <label for="goal-current_amount" class="form-label">Valor Atual (opcional)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400">R$</span>
                        <input type="number" 
                               id="goal-current_amount" 
                               name="current_amount" 
                               value="0"
                               step="0.01" 
                               min="0"
                               placeholder="0,00"
                               class="form-input pl-12 transition-all duration-200 focus:scale-[1.02]">
                    </div>
                    <div class="form-error" id="current-amount-error" style="display: none;"></div>
                </div>

                <!-- Data Limite -->
                <div class="space-y-2">
                    <label for="goal-target_date" class="form-label">Data Limite</label>
                    <input type="date" 
                           id="goal-target_date" 
                           name="target_date" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="form-input transition-all duration-200 focus:scale-[1.02]" 
                           required>
                    <div class="form-error" id="target-date-error" style="display: none;"></div>
                </div>
            </div>

            <!-- Informações sobre tipos de meta -->
            <div class="bg-primary-50/50 dark:bg-primary-800/30 rounded-xl p-4">
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
        </form>

        <div class="modal-footer">
            <button type="button" onclick="window.modalManager.close('goal-modal')" class="btn-secondary">
                Cancelar
            </button>
            <button type="submit" form="goal-form" class="btn-primary gap-2">
                <x-icons.target class="w-4 h-4" />
                Criar Meta
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const goalForm = document.getElementById('goal-form');
    
    // Submit do formulário
    goalForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Limpar erros anteriores
        document.querySelectorAll('#goal-modal .form-error').forEach(error => error.style.display = 'none');
        
        const formData = new FormData(goalForm);
        
        fetch(goalForm.action, {
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
                window.modalManager.close('goal-modal');
                // Recarregar a página ou atualizar a lista
                window.location.reload();
            } else if (data.errors) {
                // Mostrar erros de validação
                Object.keys(data.errors).forEach(field => {
                    const errorDiv = document.getElementById(field.replace('_', '-') + '-error');
                    if (errorDiv) {
                        errorDiv.textContent = data.errors[field][0];
                        errorDiv.style.display = 'block';
                    }
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar meta');
        });
    });

    // Limpar formulário quando o modal abrir
    window.modalManager.onOpen('goal-modal', function() {
        goalForm.reset();
        document.querySelectorAll('#goal-modal .form-error').forEach(error => error.style.display = 'none');
        document.getElementById('goal-current_amount').value = '0';
        
        // Definir data mínima como amanhã
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('goal-target_date').min = tomorrow.toISOString().split('T')[0];
    });
});
</script>