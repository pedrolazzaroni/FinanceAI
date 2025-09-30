<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 fade-in">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold text-primary-950 mb-2 dark:text-primary-50">
                    Assistente Financeiro
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Gerencie suas finanças de forma inteligente
                </p>
            </div>
            <button onclick="window.modalManager.open('transaction-modal')" class="btn-primary hover-lift gap-2 w-full sm:w-auto">
                <x-icons.plus class="w-4 h-4" />
                Nova Transação
            </button>
        </div>
    </x-slot>

    <!-- Cards de Métricas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 stagger-children">
        <!-- Receitas do Mês -->
        <div class="metric-card success hover-scale fade-in" data-animate>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-success/80 mb-1">Receitas do Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-success" id="income-counter">
                        R$ {{ number_format($monthlyIncome, 2, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-success/10 rounded-2xl grid place-items-center hover-scale">
                    <x-icons.trending-up class="w-5 h-5 sm:w-6 sm:h-6 text-success" />
                </div>
            </div>
        </div>

        <!-- Gastos do Mês -->
        <div class="metric-card danger hover-scale fade-in" data-animate style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-danger/80 mb-1">Gastos do Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-danger" id="expense-counter">
                        R$ {{ number_format($monthlyExpenses, 2, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-danger/10 rounded-2xl grid place-items-center hover-scale">
                    <x-icons.trending-down class="w-5 h-5 sm:w-6 sm:h-6 text-danger" />
                </div>
            </div>
        </div>

        <!-- Saldo do Mês -->
        <div class="metric-card {{ $monthlyBalance >= 0 ? 'info' : 'danger' }} hover-scale fade-in sm:col-span-2 lg:col-span-1" data-animate style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium {{ $monthlyBalance >= 0 ? 'text-info/80' : 'text-danger/80' }} mb-1">
                        Saldo do Mês
                    </p>
                    <p class="text-xl sm:text-2xl font-bold {{ $monthlyBalance >= 0 ? 'text-info' : 'text-danger' }}" id="balance-counter">
                        R$ {{ number_format($monthlyBalance, 2, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 {{ $monthlyBalance >= 0 ? 'bg-info/10' : 'bg-danger/10' }} rounded-2xl grid place-items-center hover-scale">
                    <x-icons.chart class="w-5 h-5 sm:w-6 sm:h-6 {{ $monthlyBalance >= 0 ? 'text-info' : 'text-danger' }}" />
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Ações Rápidas -->
        <div class="card-minimal slide-up fade-in" data-animate style="animation-delay: 0.3s;">
            <div class="p-4 sm:p-6">
                <div class="flex items-center mb-4 sm:mb-6">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-100 dark:bg-primary-800 rounded-xl grid place-items-center mr-3">
                        <x-icons.plus-circle class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 dark:text-primary-300" />
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Ações Rápidas</h3>
                </div>
                <div class="space-y-3">
                    <button onclick="window.modalManager.open('transaction-modal')" class="block w-full btn-primary text-center hover-lift gap-2">
                        <x-icons.plus class="w-4 h-4" />
                        Adicionar Transação
                    </button>
                    <button onclick="window.modalManager.open('goal-modal')" class="block w-full btn-secondary text-center hover-lift gap-2">
                        <x-icons.target class="w-4 h-4" />
                        Nova Meta
                    </button>
                    <a href="{{ route('transactions.index') }}" class="block w-full btn-secondary text-center hover-lift gap-2">
                        <x-icons.list class="w-4 h-4" />
                        Ver Todas as Transações
                    </a>
                    <a href="{{ route('reports.index') }}" class="block w-full btn-secondary text-center hover-lift gap-2">
                        <x-icons.chart class="w-4 h-4" />
                        Ver Relatórios
                    </a>
                </div>
            </div>
        </div>

        <!-- Transações Recentes -->
        <div class="card-minimal slide-up fade-in" data-animate style="animation-delay: 0.4s;">
            <div class="p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-100 dark:bg-primary-800 rounded-xl grid place-items-center mr-3">
                            <x-icons.clock class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 dark:text-primary-300" />
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Transações Recentes</h3>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="text-xs sm:text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-200 font-medium hover-lift">
                        Ver todas
                    </a>
                </div>

                @if($recentTransactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTransactions as $index => $transaction)
                            <div class="flex justify-between items-start sm:items-center p-3 sm:p-4 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all group transaction-item fade-in" 
                                 data-animate style="animation-delay: {{ 0.5 + ($index * 0.1) }}s;">
                                <div class="flex items-start sm:items-center min-w-0 flex-1">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white dark:bg-primary-700 rounded-xl grid place-items-center mr-3 shadow-xs group-hover:shadow-apple transition-shadow flex-shrink-0">
                                        @if($transaction->type === 'income')
                                            <x-icons.trending-up class="w-4 h-4 sm:w-5 sm:h-5 text-success" />
                                        @else
                                            <x-icons.trending-down class="w-4 h-4 sm:w-5 sm:h-5 text-danger" />
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-medium text-primary-900 dark:text-primary-100 text-sm sm:text-base truncate">
                                            {{ $transaction->description }}
                                        </div>
                                        <div class="text-xs sm:text-sm text-primary-500 dark:text-primary-400 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 mt-1">
                                            <span class="badge badge-{{ $transaction->type === 'income' ? 'success' : 'danger' }} text-xs">
                                                {{ $transaction->category->name }}
                                            </span>
                                            <span class="text-xs">{{ $transaction->transaction_date->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="font-semibold text-sm sm:text-base {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }} ml-2 whitespace-nowrap">
                                    {{ $transaction->type === 'expense' ? '-' : '+' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 sm:py-12">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-primary-100 dark:bg-primary-800 rounded-2xl grid place-items-center mx-auto mb-4">
                            <x-icons.money class="w-6 h-6 sm:w-8 sm:h-8 text-primary-400" />
                        </div>
                        <p class="text-primary-500 dark:text-primary-400 mb-4 text-sm sm:text-base">Nenhuma transação encontrada</p>
                        <button onclick="window.modalManager.open('transaction-modal')" class="btn-primary gap-2 hover-lift">
                            <x-icons.plus class="w-4 h-4" />
                            Criar primeira transação
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Gastos por Categoria -->
    @if($expensesByCategory->count() > 0)
    <div class="mt-6 sm:mt-8 slide-up fade-in" data-animate style="animation-delay: 0.6s;">
        <div class="card-minimal">
            <div class="p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-100 dark:bg-primary-800 rounded-xl grid place-items-center mr-3">
                            <x-icons.tag class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 dark:text-primary-300" />
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Gastos por Categoria</h3>
                    </div>
                    <span class="badge-neutral text-xs">Mês Atual</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 stagger-children">
                    @foreach($expensesByCategory as $index => $categoryExpense)
                        <div class="p-3 sm:p-4 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all group hover-lift category-item fade-in" 
                             data-animate style="animation-delay: {{ 0.7 + ($index * 0.1) }}s;">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center min-w-0">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white dark:bg-primary-700 rounded-xl grid place-items-center mr-3 shadow-xs group-hover:shadow-apple transition-shadow flex-shrink-0">
                                        <x-icons.tag class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600 dark:text-primary-300" />
                                    </div>
                                    <span class="font-medium text-primary-950 dark:text-primary-100 truncate text-sm sm:text-base">
                                        {{ $categoryExpense->category->name }}
                                    </span>
                                </div>
                                <div class="text-danger font-semibold text-sm sm:text-base ml-2 whitespace-nowrap">
                                    R$ {{ number_format($categoryExpense->total, 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Metas Ativas -->
    @if($activeGoals->count() > 0)
    <div class="mt-6 sm:mt-8 slide-up fade-in" data-animate style="animation-delay: 0.8s;">
        <div class="card-minimal">
            <div class="p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-success/15 rounded-xl grid place-items-center mr-3">
                            <x-icons.target class="w-4 h-4 sm:w-5 sm:h-5 text-success" />
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Metas em Andamento</h3>
                    </div>
                    <a href="{{ route('goals.index') }}" class="text-xs sm:text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-200 font-medium hover-lift">
                        Ver todas
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach($activeGoals as $index => $goal)
                        <div class="p-4 sm:p-5 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all group hover-lift fade-in" 
                             data-animate style="animation-delay: {{ 0.9 + ($index * 0.1) }}s;">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                                <div>
                                    <h4 class="font-semibold text-primary-950 dark:text-primary-100 text-sm sm:text-base">{{ $goal->name }}</h4>
                                    <p class="text-xs sm:text-sm text-primary-500 dark:text-primary-400 mt-1">
                                        Meta: R$ {{ number_format($goal->target_amount, 2, ',', '.') }} 
                                        • Prazo: {{ $goal->target_date->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-primary-600 dark:text-primary-400">
                                        {{ number_format($goal->progress_percentage, 1) }}%
                                    </div>
                                    <div class="text-xs text-primary-500 dark:text-primary-400">
                                        {{ $goal->days_remaining }} dias restantes
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs sm:text-sm">
                                    <span class="text-primary-600 dark:text-primary-400">Atual: R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</span>
                                    <span class="text-primary-600 dark:text-primary-400">Restante: R$ {{ number_format($goal->remaining_amount, 2, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-primary-100 dark:bg-primary-800 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-success to-success/80 h-2 rounded-full transition-all duration-1000 progress-bar" 
                                         style="width: 0%;" 
                                         data-width="{{ $goal->progress_percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <button onclick="window.modalManager.open('goal-modal')" class="btn-secondary w-full text-center hover-lift gap-2">
                        <x-icons.plus class="w-4 h-4" />
                        Criar Nova Meta
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="mt-6 sm:mt-8 slide-up fade-in" data-animate style="animation-delay: 0.8s;">
        <div class="card-minimal">
            <div class="p-4 sm:p-6 text-center">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-success/15 rounded-2xl grid place-items-center mx-auto mb-4">
                    <x-icons.target class="w-6 h-6 sm:w-8 sm:h-8 text-success" />
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50 mb-2">Estabeleça suas metas financeiras</h3>
                <p class="text-primary-500 dark:text-primary-400 mb-6 text-sm sm:text-base">
                    Defina objetivos claros e acompanhe seu progresso para alcançar seus sonhos financeiros.
                </p>
                <button onclick="window.modalManager.open('goal-modal')" class="btn-primary gap-2 hover-lift">
                    <x-icons.plus class="w-4 h-4" />
                    Criar Primeira Meta
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Script para animação dos contadores -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animar contadores dos valores
            animateCounter('income-counter', {{ $monthlyIncome }});
            animateCounter('expense-counter', {{ $monthlyExpenses }});
            animateCounter('balance-counter', {{ $monthlyBalance }});

            // Animar barras de progresso das metas
            setTimeout(() => {
                document.querySelectorAll('.progress-bar').forEach(bar => {
                    const targetWidth = bar.dataset.width;
                    if (targetWidth) {
                        bar.style.transition = 'width 1.5s ease-out';
                        bar.style.width = targetWidth;
                    }
                });
            }, 1000);
        });

        function animateCounter(elementId, targetValue) {
            const element = document.getElementById(elementId);
            if (!element) return;

            let startValue = 0;
            const duration = 1500;
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const currentValue = startValue + (targetValue - startValue) * progress;

                element.textContent = `R$ ${currentValue.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            }

            // Aguardar um pouco antes de iniciar
            setTimeout(() => {
                requestAnimationFrame(updateCounter);
            }, 300);
        }
    </script>
</x-app-layout>

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
                        @foreach($incomeCategories ?? [] as $category)
                            <option value="{{ $category->id }}" data-type="income">{{ $category->name }}</option>
                        @endforeach
                        @foreach($expenseCategories ?? [] as $category)
                            <option value="{{ $category->id }}" data-type="expense">{{ $category->name }}</option>
                        @endforeach
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

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">Criar Meta</button>
                    <button type="button" onclick="window.modalManager.close('goal-modal')" class="btn-secondary px-6">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script específico para as modais do dashboard
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