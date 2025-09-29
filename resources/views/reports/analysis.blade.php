<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🤖 Análise Financeira com IA
            </h2>
            <a href="{{ route('reports.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Voltar aos Relatórios
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Saúde Financeira Geral -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-8 text-center text-white">
                    <div class="text-4xl mb-4">
                        @if($analysis['overall_health'] === 'Boa')
                            😊
                        @elseif($analysis['overall_health'] === 'Neutra')
                            😐
                        @else
                            😰
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold mb-2">
                        Saúde Financeira: {{ $analysis['overall_health'] }}
                    </h3>
                    <p class="text-blue-100">
                        Baseado na análise dos seus dados financeiros
                    </p>
                </div>
            </div>

            <!-- Pontos Positivos -->
            @if(count($analysis['positive_points']) > 0)
                <div class="bg-green-50 dark:bg-green-800 border border-green-200 dark:border-green-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-2xl mr-3">✅</span>
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-100">
                                Pontos Positivos
                            </h3>
                        </div>
                        <ul class="space-y-2">
                            @foreach($analysis['positive_points'] as $point)
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2 mt-1">•</span>
                                    <span class="text-green-700 dark:text-green-200">{{ $point }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Alertas -->
            @if(count($analysis['warnings']) > 0)
                <div class="bg-yellow-50 dark:bg-yellow-800 border border-yellow-200 dark:border-yellow-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-2xl mr-3">⚠️</span>
                            <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-100">
                                Pontos de Atenção
                            </h3>
                        </div>
                        <ul class="space-y-2">
                            @foreach($analysis['warnings'] as $warning)
                                <li class="flex items-start">
                                    <span class="text-yellow-500 mr-2 mt-1">•</span>
                                    <span class="text-yellow-700 dark:text-yellow-200">{{ $warning }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Insights de Gastos -->
            @if(count($analysis['spending_insights']) > 0)
                <div class="bg-blue-50 dark:bg-blue-800 border border-blue-200 dark:border-blue-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-2xl mr-3">🔍</span>
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-100">
                                Insights de Gastos
                            </h3>
                        </div>
                        <ul class="space-y-2">
                            @foreach($analysis['spending_insights'] as $insight)
                                <li class="flex items-start">
                                    <span class="text-blue-500 mr-2 mt-1">•</span>
                                    <span class="text-blue-700 dark:text-blue-200">{{ $insight }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Recomendações -->
            @if(count($analysis['recommendations']) > 0)
                <div class="bg-purple-50 dark:bg-purple-800 border border-purple-200 dark:border-purple-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-2xl mr-3">💡</span>
                            <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-100">
                                Recomendações da IA
                            </h3>
                        </div>
                        <ul class="space-y-3">
                            @foreach($analysis['recommendations'] as $recommendation)
                                <li class="flex items-start p-3 bg-purple-100 dark:bg-purple-700 rounded-lg">
                                    <span class="text-purple-500 mr-2 mt-1">💎</span>
                                    <span class="text-purple-700 dark:text-purple-200">{{ $recommendation }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Ações Sugeridas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-3">🎯</span>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Próximos Passos
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('transactions.create') }}" 
                           class="flex items-center p-4 bg-blue-50 dark:bg-blue-800 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-700 transition duration-200">
                            <span class="text-2xl mr-3">➕</span>
                            <div>
                                <div class="font-semibold text-blue-800 dark:text-blue-100">Adicionar Transação</div>
                                <div class="text-sm text-blue-600 dark:text-blue-300">Mantenha seus dados atualizados</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('transactions.index') }}" 
                           class="flex items-center p-4 bg-green-50 dark:bg-green-800 rounded-lg hover:bg-green-100 dark:hover:bg-green-700 transition duration-200">
                            <span class="text-2xl mr-3">📊</span>
                            <div>
                                <div class="font-semibold text-green-800 dark:text-green-100">Revisar Transações</div>
                                <div class="text-sm text-green-600 dark:text-green-300">Analise seus gastos detalhadamente</div>
                            </div>
                        </a>
                        
                        <form method="POST" action="{{ route('reports.generate') }}" class="contents">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center p-4 bg-purple-50 dark:bg-purple-800 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-700 transition duration-200 w-full text-left">
                                <span class="text-2xl mr-3">🔄</span>
                                <div>
                                    <div class="font-semibold text-purple-800 dark:text-purple-100">Nova Análise</div>
                                    <div class="text-sm text-purple-600 dark:text-purple-300">Gerar análise atualizada</div>
                                </div>
                            </button>
                        </form>
                        
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-200">
                            <span class="text-2xl mr-3">🏠</span>
                            <div>
                                <div class="font-semibold text-gray-800 dark:text-gray-100">Ir ao Dashboard</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">Voltar à página inicial</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Disclaimer -->
            <div class="mt-6 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                    <span class="font-semibold">Importante:</span> Esta análise é baseada em algoritmos de inteligência artificial 
                    e serve como orientação geral. Para decisões financeiras importantes, consulte sempre um profissional especializado.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>