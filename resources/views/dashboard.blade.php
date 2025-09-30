<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-primary-950 mb-2">
                    Assistente Financeiro
                </h1>
                <p class="text-primary-600">
                    Gerencie suas finanças de forma inteligente
                </p>
            </div>
            <a href="{{ route('transactions.create') }}" class="btn-primary hover-lift gap-2">
                <x-icons.plus class="w-4 h-4" />
                Nova Transação
            </a>
        </div>
    </x-slot>

    <!-- Cards de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Receitas do Mês -->
        <div class="metric-card success hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-success/80 mb-1">Receitas do Mês</p>
                    <p class="text-2xl font-bold text-success">
                        R$ {{ number_format($monthlyIncome, 2, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-success/10 rounded-2xl grid place-items-center">
                    <x-icons.trending-up class="w-6 h-6 text-success" />
                </div>
            </div>
        </div>

        <!-- Gastos do Mês -->
        <div class="metric-card danger hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-danger/80 mb-1">Gastos do Mês</p>
                    <p class="text-2xl font-bold text-danger">
                        R$ {{ number_format($monthlyExpenses, 2, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-danger/10 rounded-2xl grid place-items-center">
                    <x-icons.trending-down class="w-6 h-6 text-danger" />
                </div>
            </div>
        </div>

        <!-- Saldo do Mês -->
        <div class="metric-card {{ $monthlyBalance >= 0 ? 'info' : 'danger' }} hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium {{ $monthlyBalance >= 0 ? 'text-info/80' : 'text-danger/80' }} mb-1">
                        Saldo do Mês
                    </p>
                    <p class="text-2xl font-bold {{ $monthlyBalance >= 0 ? 'text-info' : 'text-danger' }}">
                        R$ {{ number_format($monthlyBalance, 2, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 {{ $monthlyBalance >= 0 ? 'bg-info/10' : 'bg-danger/10' }} rounded-2xl grid place-items-center">
                    <x-icons.chart class="w-6 h-6 {{ $monthlyBalance >= 0 ? 'text-info' : 'text-danger' }}" />
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Ações Rápidas -->
        <div class="card-minimal slide-up">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl grid place-items-center mr-4">
                        <x-icons.plus-circle class="w-5 h-5 text-primary-600" />
                    </div>
                    <h3 class="text-lg font-semibold text-primary-950">Ações Rápidas</h3>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('transactions.create') }}" class="block w-full btn-primary text-center hover-lift gap-2">
                        <x-icons.plus class="w-4 h-4" />
                        Adicionar Transação
                    </a>
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
        <div class="card-minimal slide-up">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl grid place-items-center mr-4">
                            <x-icons.clock class="w-5 h-5 text-primary-600" />
                        </div>
                        <h3 class="text-lg font-semibold text-primary-950">Transações Recentes</h3>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                        Ver todas
                    </a>
                </div>

                @if($recentTransactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTransactions as $transaction)
                            <div class="flex justify-between items-center p-4 bg-primary-50/50 rounded-xl hover:bg-primary-50 transition-colors group">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-white rounded-xl grid place-items-center mr-4 shadow-xs group-hover:shadow-apple transition-shadow">
                                        @if($transaction->type === 'income')
                                            <x-icons.trending-up class="w-5 h-5 text-success" />
                                        @else
                                            <x-icons.trending-down class="w-5 h-5 text-danger" />
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-primary-900">
                                            {{ $transaction->description }}
                                        </div>
                                        <div class="text-sm text-primary-500">
                                            {{ $transaction->category->name }} • {{ $transaction->transaction_date->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="font-semibold {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->type === 'expense' ? '-' : '+' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-primary-100 rounded-2xl grid place-items-center mx-auto mb-4">
                            <x-icons.money class="w-8 h-8 text-primary-400" />
                        </div>
                        <p class="text-primary-500 mb-4">Nenhuma transação encontrada</p>
                        <a href="{{ route('transactions.create') }}" class="btn-primary gap-2">
                            <x-icons.plus class="w-4 h-4" />
                            Criar primeira transação
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Gastos por Categoria -->
    @if($expensesByCategory->count() > 0)
    <div class="mt-8 slide-up" style="animation-delay: 0.2s;">
        <div class="card-minimal">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl grid place-items-center mr-4">
                            <x-icons.tag class="w-5 h-5 text-primary-600" />
                        </div>
                        <h3 class="text-lg font-semibold text-primary-950">Gastos por Categoria</h3>
                    </div>
                    <span class="badge-neutral">Mês Atual</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($expensesByCategory as $categoryExpense)
                        <div class="p-4 bg-primary-50/50 rounded-xl hover:bg-primary-50 transition-colors group hover-lift">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-white rounded-xl grid place-items-center mr-3 shadow-xs group-hover:shadow-apple transition-shadow">
                                        <x-icons.tag class="w-4 h-4 text-primary-600" />
                                    </div>
                                    <span class="font-medium text-primary-900">
                                        {{ $categoryExpense->category->name }}
                                    </span>
                                </div>
                                <div class="text-danger font-semibold">
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
</x-app-layout>
