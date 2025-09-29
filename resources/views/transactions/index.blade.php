<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-semibold text-primary-950 mb-2">
                    Minhas Transações
                </h1>
                <p class="text-primary-600">
                    Gerencie todas as suas transações financeiras
                </p>
            </div>
            <a href="{{ route('transactions.create') }}" class="btn-primary hover-lift">
                <x-icons.plus class="w-4 h-4 mr-2" />
                Nova Transação
            </a>
        </div>
    </x-slot>

    <!-- Filtros -->
    <div class="card-minimal mb-6 slide-up">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center mr-4">
                    <x-icons.filter class="w-5 h-5 text-primary-600" />
                </div>
                <h3 class="text-lg font-semibold text-primary-950">Filtros</h3>
            </div>
            <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="form-label">Tipo</label>
                    <select name="type" class="form-select">
                        <option value="">Todos</option>
                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Receitas</option>
                        <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Gastos</option>
                    </select>
                </div>
                
                <div>
                    <label class="form-label">Categoria</label>
                    <select name="category_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="form-label">Data de</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input">
                </div>
                
                <div>
                    <label class="form-label">Data até</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full btn-secondary hover-lift">
                        <x-icons.search class="w-4 h-4 mr-2" />
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Transações -->
    <div class="card-minimal slide-up" style="animation-delay: 0.1s;">
        <div class="p-6">
            @if(session('success'))
                <div class="bg-success/10 border border-success/20 text-success px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center">
                        <x-icons.trending-up class="w-5 h-5 mr-3" />
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($transactions->count() > 0)
                <div class="space-y-3">
                    @foreach($transactions as $transaction)
                        <div class="flex justify-between items-center p-4 bg-primary-50/50 rounded-xl hover:bg-primary-50 transition-all duration-200 group hover-lift">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4 shadow-xs group-hover:shadow-apple transition-shadow">
                                    @if($transaction->type === 'income')
                                        <x-icons.trending-up class="w-6 h-6 text-success" />
                                    @else
                                        <x-icons.trending-down class="w-6 h-6 text-danger" />
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold text-primary-900">
                                        {{ $transaction->description }}
                                    </div>
                                    <div class="text-sm text-primary-500">
                                        {{ $transaction->category->name }} • {{ $transaction->transaction_date->format('d/m/Y') }}
                                        @if($transaction->notes)
                                            <br><em class="text-primary-400">{{ $transaction->notes }}</em>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <div class="font-bold text-lg {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->type === 'expense' ? '-' : '+' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn-icon">
                                        <x-icons.edit class="w-4 h-4" />
                                    </a>
                                    <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta transação?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-danger">
                                            <x-icons.trash class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="mt-8">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <x-icons.money class="w-10 h-10 text-primary-400" />
                    </div>
                    <h3 class="text-lg font-medium text-primary-900 mb-2">Nenhuma transação encontrada</h3>
                    <p class="text-primary-500 mb-6">Comece adicionando sua primeira transação financeira</p>
                    <a href="{{ route('transactions.create') }}" class="btn-primary">
                        <x-icons.plus class="w-4 h-4 mr-2" />
                        Adicionar Primeira Transação
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>