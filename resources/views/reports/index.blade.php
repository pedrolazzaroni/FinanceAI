<x-app-layout>
    <x-slot name="header">
        <div class="fade-in">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                Relatórios Financeiros
            </h1>
            <p class="text-primary-600 dark:text-primary-400 text-sm sm:text-base">
                Analise sua performance financeira com insights inteligentes
            </p>
        </div>
    </x-slot>

    <!-- Análise IA -->
    <div class="card-glass p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 fade-in" data-animate>
        <div class="text-center">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-primary-600 to-primary-800 dark:from-primary-400 dark:to-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <x-icons.chart class="w-6 h-6 sm:w-8 sm:h-8 text-white" />
            </div>
            <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold text-primary-950 dark:text-primary-50 mb-4">
                Análise Financeira Inteligente
            </h2>
            <p class="text-primary-600 dark:text-primary-400 mb-6 max-w-2xl mx-auto text-sm sm:text-base">
                Obtenha insights personalizados sobre suas finanças e recomendações para melhorar sua saúde financeira.
            </p>
            <form method="POST" action="{{ route('reports.generate') }}" class="inline" data-no-transition>
                @csrf
                <button type="submit" class="btn-primary hover-lift gap-2">
                    <x-icons.chart class="w-4 h-4" />
                    <span class="hidden sm:inline">Gerar Análise com IA</span>
                    <span class="sm:hidden">Analisar</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Evolução Mensal -->
        <div class="card-minimal p-4 sm:p-6 fade-in" data-animate style="animation-delay: 0.1s;">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mr-3">
                    <x-icons.trending-up class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 dark:text-primary-300" />
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Evolução dos Últimos 6 Meses</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @foreach($monthlyData as $index => $data)
                    <div class="evolution-item p-3 sm:p-4 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all hover-lift fade-in" 
                         data-animate style="animation-delay: {{ 0.2 + ($index * 0.1) }}s;">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-3 mb-3">
                            <div class="font-semibold text-primary-950 dark:text-primary-50 text-sm sm:text-base">
                                {{ $data['month'] }}
                            </div>
                            <div class="font-bold text-base sm:text-lg {{ $data['balance'] >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $data['balance'] >= 0 ? '+' : '' }}R$ {{ number_format($data['balance'], 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm">
                            <div class="flex items-center text-success">
                                <x-icons.trending-up class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" />
                                <span class="truncate">R$ {{ number_format($data['income'], 2, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center text-danger">
                                <x-icons.trending-down class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" />
                                <span class="truncate">R$ {{ number_format($data['expenses'], 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Gastos por Categoria -->
        <div class="card-minimal p-4 sm:p-6 fade-in" data-animate style="animation-delay: 0.2s;">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mr-3">
                    <x-icons.tag class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 dark:text-primary-300" />
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Gastos por Categoria</h3>
                <span class="ml-auto badge-neutral text-xs">Últimos 3 Meses</span>
            </div>
            @if($categoryExpenses->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @php $total = $categoryExpenses->sum('total'); @endphp
                    @foreach($categoryExpenses as $index => $expense)
                        @php $percentage = $total > 0 ? ($expense->total / $total) * 100 : 0; @endphp
                        <div class="category-item space-y-2 sm:space-y-3 fade-in" data-animate style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div class="flex items-center min-w-0">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-primary-100 dark:bg-primary-700 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                        <x-icons.tag class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600 dark:text-primary-300" />
                                    </div>
                                    <span class="font-medium text-primary-950 dark:text-primary-50 truncate text-sm sm:text-base">
                                        {{ $expense->category->name }}
                                    </span>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div class="font-semibold text-primary-950 dark:text-primary-50 text-sm sm:text-base">
                                        R$ {{ number_format($expense->total, 2, ',', '.') }}
                                    </div>
                                    <div class="text-xs sm:text-sm text-primary-500 dark:text-primary-400">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </div>
                            <div class="w-full bg-primary-100 dark:bg-primary-800 rounded-full h-1.5 sm:h-2">
                                <div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-400 dark:to-primary-600 h-1.5 sm:h-2 rounded-full transition-all duration-1000 progress-bar" 
                                     style="width: 0%;" 
                                     data-width="{{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 sm:py-8">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-primary-100 dark:bg-primary-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <x-icons.chart class="w-6 h-6 sm:w-8 sm:h-8 text-primary-400" />
                    </div>
                    <p class="text-primary-500 dark:text-primary-400 text-sm sm:text-base">Nenhum gasto registrado nos últimos 3 meses</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Resumo Geral -->
    <div class="mt-6 sm:mt-8 fade-in" data-animate style="animation-delay: 0.4s;">
        <div class="card-minimal p-4 sm:p-6">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mr-3">
                    <x-icons.chart class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 dark:text-primary-300" />
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-primary-950 dark:text-primary-50">Resumo dos Últimos 6 Meses</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @php
                    $totalIncome = collect($monthlyData)->sum('income');
                    $totalExpenses = collect($monthlyData)->sum('expenses');
                    $totalBalance = $totalIncome - $totalExpenses;
                    $avgMonthlyIncome = $totalIncome / 6;
                    $avgMonthlyExpenses = $totalExpenses / 6;
                @endphp
                
                <div class="metric-card success hover-scale fade-in" data-animate style="animation-delay: 0.5s;">
                    <div class="text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-success/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <x-icons.trending-up class="w-5 h-5 sm:w-6 sm:h-6 text-success" />
                        </div>
                        <div class="text-xs sm:text-sm text-success mb-1">Total de Receitas</div>
                        <div class="text-base sm:text-lg lg:text-xl font-bold text-success">
                            R$ {{ number_format($totalIncome, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                
                <div class="metric-card danger hover-scale fade-in" data-animate style="animation-delay: 0.6s;">
                    <div class="text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-danger/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <x-icons.trending-down class="w-5 h-5 sm:w-6 sm:h-6 text-danger" />
                        </div>
                        <div class="text-xs sm:text-sm text-danger mb-1">Total de Gastos</div>
                        <div class="text-base sm:text-lg lg:text-xl font-bold text-danger">
                            R$ {{ number_format($totalExpenses, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                
                <div class="metric-card {{ $totalBalance >= 0 ? 'info' : 'danger' }} hover-scale fade-in" data-animate style="animation-delay: 0.7s;">
                    <div class="text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 {{ $totalBalance >= 0 ? 'bg-info/20' : 'bg-danger/20' }} rounded-xl flex items-center justify-center mx-auto mb-3">
                            <x-icons.chart class="w-5 h-5 sm:w-6 sm:h-6 {{ $totalBalance >= 0 ? 'text-info' : 'text-danger' }}" />
                        </div>
                        <div class="text-xs sm:text-sm {{ $totalBalance >= 0 ? 'text-info' : 'text-danger' }} mb-1">Saldo Total</div>
                        <div class="text-base sm:text-lg lg:text-xl font-bold {{ $totalBalance >= 0 ? 'text-info' : 'text-danger' }}">
                            {{ $totalBalance >= 0 ? '+' : '' }}R$ {{ number_format($totalBalance, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                
                <div class="metric-card neutral hover-scale fade-in" data-animate style="animation-delay: 0.8s;">
                    <div class="text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <x-icons.chart class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-300" />
                        </div>
                        <div class="text-xs sm:text-sm text-primary-600 dark:text-primary-400 mb-1">Média Mensal</div>
                        <div class="text-base sm:text-lg lg:text-xl font-bold text-primary-950 dark:text-primary-50">
                            {{ ($avgMonthlyIncome - $avgMonthlyExpenses) >= 0 ? '+' : '' }}R$ {{ number_format($avgMonthlyIncome - $avgMonthlyExpenses, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animar barras de progresso
            setTimeout(() => {
                document.querySelectorAll('.progress-bar').forEach(bar => {
                    const targetWidth = bar.dataset.width;
                    if (targetWidth) {
                        bar.style.transition = 'width 2s ease-out';
                        bar.style.width = targetWidth;
                    }
                });
            }, 500);
        });
    </script>
</x-app-layout>