<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 fade-in">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    🤖 Análise Financeira com IA
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Insights personalizados baseados nos seus dados financeiros
                </p>
            </div>
            <a href="{{ route('reports.index') }}" class="btn-secondary hover-lift gap-2">
                <x-icons.arrow-left class="w-4 h-4" />
                Voltar aos Relatórios
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Saúde Financeira Geral -->
        <div class="card-glass p-6 sm:p-8 text-center fade-in" data-animate>
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br 
                {{ $analysis['overall_health'] === 'Boa' ? 'from-success to-success/80' : 
                   ($analysis['overall_health'] === 'Neutra' ? 'from-info to-info/80' : 'from-danger to-danger/80') }} 
                flex items-center justify-center text-white text-2xl">
                @if($analysis['overall_health'] === 'Boa')
                    😊
                @elseif($analysis['overall_health'] === 'Neutra')
                    😐
                @else
                    😰
                @endif
            </div>
            <h2 class="text-xl sm:text-2xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                Saúde Financeira: <span class="
                    {{ $analysis['overall_health'] === 'Boa' ? 'text-success' : 
                       ($analysis['overall_health'] === 'Neutra' ? 'text-info' : 'text-danger') }}">
                    {{ $analysis['overall_health'] }}
                </span>
            </h2>
            <p class="text-primary-600 dark:text-primary-400">
                Baseado na análise inteligente dos seus dados financeiros
            </p>
        </div>

        <!-- Grid de Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pontos Positivos -->
            @if(count($analysis['positive_points']) > 0)
            <div class="card-minimal p-6 fade-in" data-animate style="animation-delay: 0.1s;">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-success/15 rounded-xl flex items-center justify-center mr-3">
                        <x-icons.check class="w-5 h-5 text-success" />
                    </div>
                    <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50">
                        Pontos Positivos
                    </h3>
                </div>
                <div class="space-y-3">
                    @foreach($analysis['positive_points'] as $point)
                        <div class="flex items-start gap-3 p-3 bg-success/5 rounded-xl">
                            <span class="w-1.5 h-1.5 bg-success rounded-full mt-2 flex-shrink-0"></span>
                            <span class="text-sm text-primary-700 dark:text-primary-300">{{ $point }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Alertas -->
            @if(count($analysis['warnings']) > 0)
            <div class="card-minimal p-6 fade-in" data-animate style="animation-delay: 0.2s;">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-warning/15 rounded-xl flex items-center justify-center mr-3">
                        <x-icons.alert class="w-5 h-5 text-warning" />
                    </div>
                    <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50">
                        Pontos de Atenção
                    </h3>
                </div>
                <div class="space-y-3">
                    @foreach($analysis['warnings'] as $warning)
                        <div class="flex items-start gap-3 p-3 bg-warning/5 rounded-xl">
                            <span class="w-1.5 h-1.5 bg-warning rounded-full mt-2 flex-shrink-0"></span>
                            <span class="text-sm text-primary-700 dark:text-primary-300">{{ $warning }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Insights de Gastos -->
        @if(count($analysis['spending_insights']) > 0)
        <div class="card-minimal p-6 fade-in" data-animate style="animation-delay: 0.3s;">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-info/15 rounded-xl flex items-center justify-center mr-3">
                    <x-icons.search class="w-5 h-5 text-info" />
                </div>
                <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50">
                    Insights de Gastos
                </h3>
            </div>
            <div class="space-y-3">
                @foreach($analysis['spending_insights'] as $insight)
                    <div class="flex items-start gap-3 p-4 bg-info/5 rounded-xl hover-lift">
                        <span class="w-1.5 h-1.5 bg-info rounded-full mt-2 flex-shrink-0"></span>
                        <span class="text-sm text-primary-700 dark:text-primary-300">{{ $insight }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recomendações -->
        @if(count($analysis['recommendations']) > 0)
        <div class="card-minimal p-6 fade-in" data-animate style="animation-delay: 0.4s;">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mr-3">
                    <x-icons.target class="w-5 h-5 text-primary-600 dark:text-primary-300" />
                </div>
                <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50">
                    Recomendações da IA
                </h3>
            </div>
            <div class="space-y-4">
                @foreach($analysis['recommendations'] as $index => $recommendation)
                    <div class="recommendation-item p-4 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all hover-lift fade-in" 
                         data-animate style="animation-delay: {{ 0.5 + ($index * 0.1) }}s;">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-primary-100 dark:bg-primary-700 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-semibold text-primary-600 dark:text-primary-300">{{ $index + 1 }}</span>
                            </div>
                            <span class="text-sm text-primary-700 dark:text-primary-300">{{ $recommendation }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Ações Sugeridas -->
        <div class="card-minimal p-6 fade-in" data-animate style="animation-delay: 0.6s;">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-800 rounded-xl flex items-center justify-center mr-3">
                    <x-icons.plus class="w-5 h-5 text-primary-600 dark:text-primary-300" />
                </div>
                <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50">
                    Próximos Passos
                </h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('transactions.create') }}" 
                   class="action-card p-4 bg-success/5 border border-success/20 rounded-xl hover:bg-success/10 transition-all hover-lift group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-success/20 rounded-lg flex items-center justify-center group-hover:bg-success/30 transition-colors">
                            <x-icons.plus class="w-5 h-5 text-success" />
                        </div>
                        <div>
                            <div class="font-semibold text-success">Adicionar Transação</div>
                            <div class="text-xs text-primary-500 dark:text-primary-400">Mantenha seus dados atualizados</div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('transactions.index') }}" 
                   class="action-card p-4 bg-info/5 border border-info/20 rounded-xl hover:bg-info/10 transition-all hover-lift group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-info/20 rounded-lg flex items-center justify-center group-hover:bg-info/30 transition-colors">
                            <x-icons.list class="w-5 h-5 text-info" />
                        </div>
                        <div>
                            <div class="font-semibold text-info">Revisar Transações</div>
                            <div class="text-xs text-primary-500 dark:text-primary-400">Analise seus gastos detalhadamente</div>
                        </div>
                    </div>
                </a>
                
                <form method="POST" action="{{ route('reports.generate') }}" class="contents" data-no-transition>
                    @csrf
                    <button type="submit" 
                            class="action-card p-4 bg-warning/5 border border-warning/20 rounded-xl hover:bg-warning/10 transition-all hover-lift group w-full text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-warning/20 rounded-lg flex items-center justify-center group-hover:bg-warning/30 transition-colors">
                                <x-icons.chart class="w-5 h-5 text-warning" />
                            </div>
                            <div>
                                <div class="font-semibold text-warning">Nova Análise</div>
                                <div class="text-xs text-primary-500 dark:text-primary-400">Gerar análise atualizada</div>
                            </div>
                        </div>
                    </button>
                </form>
                
                <a href="{{ route('dashboard') }}" 
                   class="action-card p-4 bg-primary-50/50 dark:bg-primary-800/30 border border-primary-200/50 dark:border-primary-700/50 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all hover-lift group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 dark:bg-primary-700 rounded-lg flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-600 transition-colors">
                            <x-icons.home class="w-5 h-5 text-primary-600 dark:text-primary-300" />
                        </div>
                        <div>
                            <div class="font-semibold text-primary-900 dark:text-primary-100">Ir ao Dashboard</div>
                            <div class="text-xs text-primary-500 dark:text-primary-400">Voltar à página inicial</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="card-minimal p-4 border border-primary-200/50 dark:border-primary-700/50 fade-in" data-animate style="animation-delay: 0.7s;">
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 bg-info/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                    <x-icons.alert class="w-3 h-3 text-info" />
                </div>
                <div>
                    <p class="text-sm text-primary-600 dark:text-primary-400">
                        <span class="font-semibold">Importante:</span> Esta análise é baseada em algoritmos de inteligência artificial 
                        e serve como orientação geral. Para decisões financeiras importantes, consulte sempre um profissional especializado.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>