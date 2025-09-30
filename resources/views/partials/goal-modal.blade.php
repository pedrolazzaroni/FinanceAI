<!-- Modal de Nova Meta -->
<div id="goal-modal" class="modal hidden">
    <div class="modal-backdrop" onclick="window.modalManager.close('goal-modal')"></div>
    <div class="modal-content">
        <div class="p-4 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg sm:text-xl font-semibold text-primary-950 dark:text-primary-50">Nova Meta Financeira</h2>
                <button onclick="window.modalManager.close('goal-modal')" class="btn-icon p-2">
                    <x-icons.x class="w-4 h-4" />
                </button>
            </div>

            <form action="{{ route('goals.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nome da Meta -->
                <div class="space-y-2">
                    <label for="goal_name" class="form-label">Nome da Meta</label>
                    <input type="text" name="name" id="goal_name" placeholder="Ex: Reserva de emergência" class="form-input" required>
                </div>

                <!-- Descrição -->
                <div class="space-y-2">
                    <label for="goal_description" class="form-label">Descrição (opcional)</label>
                    <textarea name="description" id="goal_description" rows="2" placeholder="Descreva sua meta..." class="form-textarea"></textarea>
                </div>

                <!-- Valor e Tipo -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="goal_target_amount" class="form-label">Valor da Meta</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400 text-sm">R$</span>
                            <input type="number" name="target_amount" id="goal_target_amount" step="0.01" min="0.01" placeholder="0,00" class="form-input pl-10" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="goal_type" class="form-label">Tipo de Meta</label>
                        <select name="type" id="goal_type" class="form-select" required>
                            <option value="">Selecione o tipo</option>
                            <option value="savings">Poupança</option>
                            <option value="expense_reduction">Redução de Gastos</option>
                            <option value="income_increase">Aumento de Renda</option>
                        </select>
                    </div>
                </div>

                <!-- Valor atual e Data -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="goal_current_amount" class="form-label">Valor Atual (opcional)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-primary-500 dark:text-primary-400 text-sm">R$</span>
                            <input type="number" name="current_amount" id="goal_current_amount" step="0.01" min="0" value="0" placeholder="0,00" class="form-input pl-10">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="goal_target_date" class="form-label">Data Limite</label>
                        <input type="date" name="target_date" id="goal_target_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="form-input" required>
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

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">Criar Meta</button>
                    <button type="button" onclick="window.modalManager.close('goal-modal')" class="btn-secondary px-6">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>