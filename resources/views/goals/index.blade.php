<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between fade-in">
            <div>
                <h1 class="text-3xl font-semibold text-primary-950 dark:text-primary-50 mb-2">
                    Metas Financeiras
                </h1>
                <p class="text-primary-600 dark:text-primary-400">
                    Acompanhe seu progresso em direção aos seus objetivos financeiros
                </p>
            </div>
            <button onclick="window.modalManager.open('goal-modal')" class="btn-primary hover-lift gap-2">
                <x-icons.plus class="w-4 h-4" />
                Nova Meta
            </button>
        </div>
    </x-slot>

    <!-- Estatísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 stagger-children">
        <div class="metric-card info hover-scale fade-in" data-animate>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-info/80 mb-1">Metas Ativas</p>
                    <p class="text-2xl font-bold text-info">{{ $activeGoals->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-info/10 rounded-2xl grid place-items-center">
                    <x-icons.target class="w-6 h-6 text-info" />
                </div>
            </div>
        </div>

        <div class="metric-card success hover-scale fade-in" data-animate style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-success/80 mb-1">Metas Concluídas</p>
                    <p class="text-2xl font-bold text-success">{{ $completedGoals->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-success/10 rounded-2xl grid place-items-center">
                    <x-icons.check class="w-6 h-6 text-success" />
                </div>
            </div>
        </div>

        <div class="metric-card neutral hover-scale fade-in" data-animate style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-primary-600/80 dark:text-primary-400/80 mb-1">Progresso Médio</p>
                    <p class="text-2xl font-bold text-primary-900 dark:text-primary-100">
                        {{ $activeGoals->count() > 0 ? number_format($activeGoals->avg('progress_percentage'), 0) : 0 }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-800 rounded-2xl grid place-items-center">
                    <x-icons.chart class="w-6 h-6 text-primary-600 dark:text-primary-300" />
                </div>
            </div>
        </div>
    </div>

    <!-- Metas Ativas -->
    @if($activeGoals->count() > 0)
    <div class="mb-8 fade-in" data-animate style="animation-delay: 0.3s;">
        <div class="card-minimal">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-primary-950 dark:text-primary-50 mb-6">Metas em Andamento</h2>
                <div class="space-y-6">
                    @foreach($activeGoals as $index => $goal)
                    <div class="goal-card p-6 bg-primary-50/50 dark:bg-primary-800/30 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all group hover-lift fade-in"
                         data-animate style="animation-delay: {{ 0.4 + ($index * 0.1) }}s;">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-primary-950 dark:text-primary-50">{{ $goal->name }}</h3>
                                        @if($goal->description)
                                        <p class="text-sm text-primary-600 dark:text-primary-400 mt-1">{{ $goal->description }}</p>
                                        @endif
                                        <div class="flex items-center gap-4 mt-2 text-sm text-primary-500 dark:text-primary-400">
                                            <span class="badge badge-{{ $goal->type === 'savings' ? 'info' : ($goal->type === 'expense_reduction' ? 'danger' : 'success') }}">
                                                {{ ucfirst(str_replace('_', ' ', $goal->type)) }}
                                            </span>
                                            <span>Prazo: {{ $goal->target_date->format('d/m/Y') }}</span>
                                            <span class="{{ $goal->is_overdue ? 'text-danger font-medium' : '' }}">
                                                {{ $goal->days_remaining }} dias restantes
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('goals.edit', $goal) }}" class="btn-icon hover-scale">
                                            <x-icons.edit class="w-4 h-4" />
                                        </a>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-primary-900 dark:text-primary-100">
                                            R$ {{ number_format($goal->current_amount, 2, ',', '.') }}
                                        </span>
                                        <span class="text-lg font-semibold">
                                            {{ number_format($goal->progress_percentage, 1) }}%
                                        </span>
                                    </div>

                                    <div class="relative">
                                        <div class="w-full bg-primary-100 dark:bg-primary-800 rounded-full h-3">
                                            <div class="bg-gradient-to-r from-success to-success/80 h-3 rounded-full transition-all duration-1000 progress-bar"
                                                 style="width: 0%;"
                                                 data-width="{{ $goal->progress_percentage }}%"></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between text-sm text-primary-600 dark:text-primary-400">
                                        <span>Atual: R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</span>
                                        <span>Meta: R$ {{ number_format($goal->target_amount, 2, ',', '.') }}</span>
                                    </div>

                                    @if($goal->remaining_amount > 0)
                                    <p class="text-sm text-primary-500 dark:text-primary-400">
                                        Faltam R$ {{ number_format($goal->remaining_amount, 2, ',', '.') }} para atingir sua meta
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 lg:w-48">
                                <form action="{{ route('goals.update-progress', $goal) }}" method="POST" class="space-y-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number"
                                           name="amount"
                                           step="0.01"
                                           min="0"
                                           value="{{ $goal->current_amount }}"
                                           placeholder="Valor atual"
                                           class="form-input text-sm">
                                    <button type="submit" class="btn-secondary w-full text-sm">
                                        Atualizar Progresso
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Metas Concluídas -->
    @if($completedGoals->count() > 0)
    <div class="fade-in" data-animate style="animation-delay: 0.5s;">
        <div class="card-minimal">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-primary-950 dark:text-primary-50 mb-6">Metas Concluídas Recentemente</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($completedGoals as $index => $goal)
                    <div class="p-4 bg-success/5 border border-success/20 rounded-xl hover-lift fade-in"
                         data-animate style="animation-delay: {{ 0.6 + ($index * 0.1) }}s;">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-primary-950 dark:text-primary-50">{{ $goal->name }}</h3>
                            <span class="badge-success">Concluída</span>
                        </div>
                        <p class="text-sm text-primary-600 dark:text-primary-400 mb-2">
                            Meta: R$ {{ number_format($goal->target_amount, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-primary-500 dark:text-primary-400">
                            Concluída em {{ $goal->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Estado vazio -->
    @if($activeGoals->count() === 0 && $completedGoals->count() === 0)
    <div class="text-center py-16 fade-in" data-animate>
        <div class="w-24 h-24 bg-primary-100 dark:bg-primary-800 rounded-3xl grid place-items-center mx-auto mb-6">
            <x-icons.target class="w-12 h-12 text-primary-400" />
        </div>
        <h3 class="text-2xl font-semibold text-primary-950 dark:text-primary-50 mb-3">Suas metas aparecerão aqui</h3>
        <p class="text-primary-600 dark:text-primary-400 max-w-md mx-auto mb-8">
            Defina objetivos financeiros claros e acompanhe seu progresso. Comece criando sua primeira meta!
        </p>
        <button onclick="window.modalManager.open('goal-modal')" class="btn-primary gap-2 hover-lift">
            <x-icons.plus class="w-4 h-4" />
            Criar Primeira Meta
        </button>
    </div>
    @endif

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
<!-- Incluir modal de metas -->
@include('partials.goal-modal')
