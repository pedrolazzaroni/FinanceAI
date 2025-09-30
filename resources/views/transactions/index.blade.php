<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 fade-in">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    Minhas Transações
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Gerencie todas as suas transações financeiras
                </p>
            </div>
            <button onclick="window.modalManager.open('transaction-modal')" class="btn-primary hover-lift gap-2 w-full sm:w-auto">
                <x-icons.plus class="w-4 h-4" />
                Nova Transação
            </button>
        </div>
    </x-slot>

    <!-- Filtros -->
    <div class="card-minimal mb-6 slide-up fade-in" data-animate>
        <div class="p-4 sm:p-6">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mr-3">
                    <x-icons.filter class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 dark:text-primary-300" />
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Filtros</h3>
            </div>
            <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                <div>
                    <label class="form-label">Tipo</label>
                    <select name="type" class="form-select transition-all duration-200 focus:scale-[1.02]">
                        <option value="">Todos</option>
                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Receitas</option>
                        <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Gastos</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Categoria</label>
                    <select name="category_id" class="form-select transition-all duration-200 focus:scale-[1.02]">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Data Inicial</label>
                    <input type="date"
                           name="date_from"
                           value="{{ request('date_from') }}"
                           class="form-input transition-all duration-200 focus:scale-[1.02]">
                </div>

                <div>
                    <label class="form-label">Data Final</label>
                    <input type="date"
                           name="date_to"
                           value="{{ request('date_to') }}"
                           class="form-input transition-all duration-200 focus:scale-[1.02]">
                </div>

                <div class="flex flex-col sm:flex-row items-end gap-2 sm:col-span-1">
                    <button type="submit" class="btn-primary w-full sm:flex-1 hover-lift gap-2">
                        <x-icons.search class="w-4 h-4" />
                        <span class="hidden sm:inline">Filtrar</span>
                        <span class="sm:hidden">Buscar</span>
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn-secondary w-full sm:w-auto px-3 py-3 hover-lift flex justify-center">
                        <x-icons.x class="w-4 h-4" />
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Transações -->
    @if($transactions->count() > 0)
    <div class="card-minimal fade-in" data-animate style="animation-delay: 0.2s;">
        <div class="p-4 sm:p-6">
            @if(session('success'))
                <div class="bg-success/10 border border-success/20 text-success px-4 py-3 rounded-xl mb-6 fade-in" data-auto-dismiss="5000">
                    <div class="flex items-center">
                        <x-icons.check class="w-5 h-5 mr-3 flex-shrink-0" />
                        <span class="text-sm sm:text-base">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">
                    Transações
                    <span class="text-xs sm:text-sm font-normal text-primary-500 dark:text-primary-400 block sm:inline">
                        ({{ $transactions->total() }} {{ $transactions->total() === 1 ? 'resultado' : 'resultados' }})
                    </span>
                </h3>
                <div class="text-xs sm:text-sm text-primary-600 dark:text-primary-400">
                    Página {{ $transactions->currentPage() }} de {{ $transactions->lastPage() }}
                </div>
            </div>

            <div class="space-y-3">
                @foreach($transactions as $index => $transaction)
                <div class="transaction-item p-3 sm:p-4 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all group fade-in"
                     data-animate style="animation-delay: {{ 0.3 + ($index * 0.05) }}s;">
                    <div class="flex items-start sm:items-center justify-between gap-3">
                        <div class="flex items-start sm:items-center flex-1 min-w-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white dark:bg-primary-700 rounded-xl grid place-items-center mr-3 shadow-xs group-hover:shadow-apple transition-shadow flex-shrink-0">
                                @if($transaction->type === 'income')
                                    <x-icons.trending-up class="w-5 h-5 sm:w-6 sm:h-6 text-success" />
                                @else
                                    <x-icons.trending-down class="w-5 h-5 sm:w-6 sm:h-6 text-danger" />
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div class="min-w-0">
                                        <h4 class="font-semibold text-primary-950 dark:text-primary-50 text-sm sm:text-base truncate">
                                            {{ $transaction->description }}
                                        </h4>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 mt-1 text-xs sm:text-sm text-primary-500 dark:text-primary-400">
                                            <span class="badge badge-{{ $transaction->type === 'income' ? 'success' : 'danger' }} text-xs">
                                                {{ $transaction->category->name }}
                                            </span>
                                            <span class="whitespace-nowrap">{{ $transaction->transaction_date->format('d/m/Y') }}</span>
                                            @if($transaction->notes)
                                                <span class="text-xs truncate">• {{ Str::limit($transaction->notes, 20) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-start gap-2 sm:gap-0">
                                        <div class="text-base sm:text-xl font-bold {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type === 'expense' ? '-' : '+' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                        </div>
                                        <div class="flex items-center gap-1 sm:gap-2 sm:mt-2">
                                            <a href="{{ route('transactions.edit', $transaction) }}"
                                               class="btn-icon hover-scale p-1.5 sm:p-2"
                                               title="Editar">
                                                <x-icons.edit class="w-3 h-3 sm:w-4 sm:h-4" />
                                            </a>
                                            <form action="{{ route('transactions.destroy', $transaction) }}"
                                                  method="POST"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn-icon-danger hover-scale p-1.5 sm:p-2"
                                                        title="Excluir"
                                                        onclick="return confirm('Tem certeza de que deseja excluir esta transação?')">
                                                    <x-icons.trash class="w-3 h-3 sm:w-4 sm:h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginação -->
            @if($transactions->hasPages())
            <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-primary-100 dark:border-primary-800 fade-in"
                 data-animate style="animation-delay: 0.5s;">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2 order-2 sm:order-1">
                        @if($transactions->onFirstPage())
                            <span class="btn-secondary opacity-50 cursor-not-allowed gap-2 text-xs sm:text-sm">
                                <x-icons.arrow-left class="w-3 h-3 sm:w-4 sm:h-4" />
                                <span class="hidden sm:inline">Anterior</span>
                                <span class="sm:hidden">Ant</span>
                            </span>
                        @else
                            <a href="{{ $transactions->previousPageUrl() }}" class="btn-secondary hover-lift gap-2 text-xs sm:text-sm">
                                <x-icons.arrow-left class="w-3 h-3 sm:w-4 sm:h-4" />
                                <span class="hidden sm:inline">Anterior</span>
                                <span class="sm:hidden">Ant</span>
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center gap-1 order-1 sm:order-2">
                        @foreach($transactions->getUrlRange(max(1, $transactions->currentPage() - 2), min($transactions->lastPage(), $transactions->currentPage() + 2)) as $page => $url)
                            @if($page == $transactions->currentPage())
                                <span class="px-2 sm:px-3 py-1 sm:py-2 bg-primary-900 dark:bg-primary-100 text-white dark:text-primary-900 rounded-lg font-medium text-xs sm:text-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="px-2 sm:px-3 py-1 sm:py-2 bg-primary-50 dark:bg-primary-800 text-primary-600 dark:text-primary-400 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-700 transition-colors hover-scale text-xs sm:text-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <div class="flex items-center gap-2 order-3">
                        @if($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" class="btn-secondary hover-lift gap-2 text-xs sm:text-sm">
                                <span class="hidden sm:inline">Próxima</span>
                                <span class="sm:hidden">Próx</span>
                                <x-icons.arrow-right class="w-3 h-3 sm:w-4 sm:h-4" />
                            </a>
                        @else
                            <span class="btn-secondary opacity-50 cursor-not-allowed gap-2 text-xs sm:text-sm">
                                <span class="hidden sm:inline">Próxima</span>
                                <span class="sm:hidden">Próx</span>
                                <x-icons.arrow-right class="w-3 h-3 sm:w-4 sm:h-4" />
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="text-center py-12 sm:py-16 fade-in" data-animate>
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-primary-100 dark:bg-primary-800 rounded-2xl sm:rounded-3xl grid place-items-center mx-auto mb-4 sm:mb-6">
            <x-icons.money class="w-8 h-8 sm:w-12 sm:h-12 text-primary-400" />
        </div>
        <h3 class="text-xl sm:text-2xl font-semibold text-primary-950 dark:text-primary-50 mb-3">
            @if(request()->hasAny(['type', 'category_id', 'date_from', 'date_to']))
                Nenhuma transação encontrada
            @else
                Suas transações aparecerão aqui
            @endif
        </h3>
        <p class="text-primary-600 dark:text-primary-400 max-w-md mx-auto mb-6 sm:mb-8 text-sm sm:text-base px-4">
            @if(request()->hasAny(['type', 'category_id', 'date_from', 'date_to']))
                Tente ajustar os filtros para encontrar o que você está procurando.
            @else
                Comece registrando sua primeira transação para começar a gerenciar suas finanças.
            @endif
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center px-4">
            <button onclick="window.modalManager.open('transaction-modal')" class="btn-primary gap-2 hover-lift">
                <x-icons.plus class="w-4 h-4" />
                {{ request()->hasAny(['type', 'category_id', 'date_from', 'date_to']) ? 'Nova Transação' : 'Criar Primeira Transação' }}
            </button>
            @if(request()->hasAny(['type', 'category_id', 'date_from', 'date_to']))
                <a href="{{ route('transactions.index') }}" class="btn-secondary hover-lift">
                    Limpar Filtros
                </a>
            @endif
        </div>
    </div>
    @endif
</x-app-layout>
<!-- Incluir modais -->
@include('partials.transaction-modal')
