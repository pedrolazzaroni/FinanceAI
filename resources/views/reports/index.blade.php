<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold text-apple-gray-900">
            Relatórios Financeiros
        </h1>
    </x-slot>

    <!-- Análise IA -->
    <div class="bg-gradient-to-r from-apple-gray-900 to-apple-gray-700 rounded-2xl p-8 mb-8 text-white">
        <div class="text-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0L19.2 12l-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-semibold mb-4">
                Análise Financeira Inteligente
            </h3>
            <p class="text-white text-opacity-80 mb-6 max-w-2xl mx-auto">
                Obtenha insights personalizados sobre suas finanças e recomendações para melhorar sua saúde financeira.
            </p>
            <form method="POST" action="{{ route('reports.generate') }}" class="inline">
                @csrf
                <button type="submit" class="bg-white text-apple-gray-900 font-medium py-3 px-8 rounded-xl hover:bg-apple-gray-100 transition-all duration-200">
                    Gerar Análise
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Evolução Mensal -->
        <div class="card-minimal">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <x-icons.trending-up class="w-5 h-5 text-apple-gray-600 mr-3" />
                    <h3 class="text-lg font-semibold text-apple-gray-900">Evolução dos Últimos 6 Meses</h3>
                </div>
                <div class="space-y-4">
                    @foreach($monthlyData as $data)
                        <div class="p-4 bg-apple-gray-50 rounded-xl">
                            <div class="flex justify-between items-center mb-3">
                                <div class="font-semibold text-apple-gray-900">
                                    {{ $data['month'] }}
                                </div>
                                <div class="font-bold {{ $data['balance'] >= 0 ? 'text-finance-income' : 'text-finance-expense' }}">
                                    {{ $data['balance'] >= 0 ? '+' : '' }}R$ {{ number_format($data['balance'], 2, ',', '.') }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center text-finance-income">
                                    <x-icons.trending-up class="w-4 h-4 mr-2" />
                                    R$ {{ number_format($data['income'], 2, ',', '.') }}
                                </div>
                                <div class="flex items-center text-finance-expense">
                                    <x-icons.trending-down class="w-4 h-4 mr-2" />
                                    R$ {{ number_format($data['expenses'], 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Gastos por Categoria -->
        <div class="card-minimal">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <x-icons.tag class="w-5 h-5 text-apple-gray-600 mr-3" />
                    <h3 class="text-lg font-semibold text-apple-gray-900">Gastos por Categoria (Últimos 3 Meses)</h3>
                </div>
                @if($categoryExpenses->count() > 0)
                    <div class="space-y-4">
                        @php $total = $categoryExpenses->sum('total'); @endphp
                        @foreach($categoryExpenses as $expense)
                            @php $percentage = $total > 0 ? ($expense->total / $total) * 100 : 0; @endphp
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-apple-gray-200 rounded-lg flex items-center justify-center mr-3">
                                            <x-icons.tag class="w-4 h-4 text-apple-gray-600" />
                                        </div>
                                        <span class="font-medium text-apple-gray-900">
                                            {{ $expense->category->name }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-semibold text-apple-gray-900">
                                            R$ {{ number_format($expense->total, 2, ',', '.') }}
                                        </div>
                                        <div class="text-sm text-apple-gray-500">
                                            {{ number_format($percentage, 1) }}%
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full bg-apple-gray-200 rounded-full h-2">
                                    <div class="bg-apple-gray-700 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-apple-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-icons.chart class="w-8 h-8 text-apple-gray-400" />
                        </div>
                        <p class="text-apple-gray-500">Nenhum gasto registrado nos últimos 3 meses</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Resumo Geral -->
    <div class="mt-8">
        <div class="card-minimal">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <x-icons.chart class="w-5 h-5 text-apple-gray-600 mr-3" />
                    <h3 class="text-lg font-semibold text-apple-gray-900">Resumo dos Últimos 6 Meses</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @php
                        $totalIncome = collect($monthlyData)->sum('income');
                        $totalExpenses = collect($monthlyData)->sum('expenses');
                        $totalBalance = $totalIncome - $totalExpenses;
                        $avgMonthlyIncome = $totalIncome / 6;
                        $avgMonthlyExpenses = $totalExpenses / 6;
                    @endphp
                    
                    <div class="metric-card income">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-emerald-200 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <x-icons.trending-up class="w-6 h-6 text-emerald-600" />
                            </div>
                            <div class="text-sm text-emerald-600 mb-1">Total de Receitas</div>
                            <div class="text-xl font-bold text-emerald-900">
                                R$ {{ number_format($totalIncome, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="metric-card expense">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-200 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <x-icons.trending-down class="w-6 h-6 text-red-600" />
                            </div>
                            <div class="text-sm text-red-600 mb-1">Total de Gastos</div>
                            <div class="text-xl font-bold text-red-900">
                                R$ {{ number_format($totalExpenses, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="metric-card {{ $totalBalance >= 0 ? 'balance' : 'expense' }}">
                        <div class="text-center">
                            <div class="w-12 h-12 {{ $totalBalance >= 0 ? 'bg-blue-200' : 'bg-red-200' }} rounded-xl flex items-center justify-center mx-auto mb-3">
                                <x-icons.chart class="w-6 h-6 {{ $totalBalance >= 0 ? 'text-blue-600' : 'text-red-600' }}" />
                            </div>
                            <div class="text-sm {{ $totalBalance >= 0 ? 'text-blue-600' : 'text-red-600' }} mb-1">Saldo Total</div>
                            <div class="text-xl font-bold {{ $totalBalance >= 0 ? 'text-blue-900' : 'text-red-900' }}">
                                {{ $totalBalance >= 0 ? '+' : '' }}R$ {{ number_format($totalBalance, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="metric-card neutral">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-apple-gray-200 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <x-icons.chart class="w-6 h-6 text-apple-gray-600" />
                            </div>
                            <div class="text-sm text-apple-gray-600 mb-1">Média Mensal</div>
                            <div class="text-xl font-bold text-apple-gray-900">
                                {{ ($avgMonthlyIncome - $avgMonthlyExpenses) >= 0 ? '+' : '' }}R$ {{ number_format($avgMonthlyIncome - $avgMonthlyExpenses, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>