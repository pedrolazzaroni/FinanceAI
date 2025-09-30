<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FinanceAI — Assistente Financeiro Inteligente</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-primary-50 dark:bg-primary-950 text-primary-900 dark:text-primary-100 antialiased">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-[-10rem] left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-primary-300/40 blur-3xl dark:bg-primary-800/40" data-parallax="0.3"></div>
                <div class="absolute bottom-[-12rem] right-[-6rem] h-[28rem] w-[28rem] rounded-full bg-info/10 blur-3xl dark:bg-info/20" data-parallax="0.5"></div>
                <div class="absolute top-1/3 left-[-8rem] h-[22rem] w-[22rem] rounded-full bg-success/10 blur-3xl dark:bg-success/20" data-parallax="0.2"></div>
            </div>

            <header class="relative border-b border-white/10 dark:border-primary-900/30 backdrop-blur-xl bg-white/70 dark:bg-primary-900/60 sticky top-0 z-50">
                <div class="max-w-6xl mx-auto px-6 sm:px-8 py-6 flex items-center justify-between">
                    <a href="/" class="flex items-center gap-3 text-primary-900 dark:text-primary-100 hover-lift">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-900 text-white text-lg font-semibold shadow-apple dark:bg-primary-100 dark:text-primary-900">F</span>
                        <span class="text-lg font-semibold tracking-tight">FinanceAI</span>
                    </a>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-secondary hidden sm:inline-flex">Dashboard</a>
                                <a href="{{ route('reports.index') }}" class="btn-ghost hidden sm:inline-flex">Relatórios</a>
                            @else
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-secondary hidden sm:inline-flex">Criar conta</a>
                                @endif
                                <a href="{{ route('login') }}" class="btn-primary">Entrar</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </header>

            <main class="relative">
                <section class="max-w-6xl mx-auto px-6 sm:px-8 pt-20 lg:pt-28 pb-24">
                    <div class="grid gap-16 lg:grid-cols-[1.1fr_1fr] items-center">
                        <div class="space-y-8 fade-in">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-2 text-sm font-medium text-primary-600 shadow-apple dark:bg-primary-900/80 dark:text-primary-200 animate-in delay-1">
                                <span class="h-2 w-2 rounded-full bg-success animate-pulse"></span>
                                Inteligência financeira em tempo real
                            </span>
                            <div class="space-y-5 animate-in delay-2">
                                <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight text-primary-950 dark:text-primary-50">
                                    Controle total das suas finanças com um toque minimalista
                                </h1>
                                <p class="text-lg text-primary-600 dark:text-primary-300 max-w-xl">
                                    Planeje, acompanhe e otimize cada decisão financeira com dashboards intuitivos, relatórios inteligentes e automações guiadas por IA — tudo em um só lugar.
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3 animate-in delay-3">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn-primary">Acessar dashboard</a>
                                    <a href="{{ route('reports.index') }}" class="btn-secondary">Ver relatórios</a>
                                @else
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn-primary">Começar gratuitamente</a>
                                    @endif
                                    <a href="{{ route('login') }}" class="btn-secondary">Já tenho conta</a>
                                @endauth
                            </div>
                            <div class="flex flex-wrap items-center gap-6 text-sm text-primary-500 dark:text-primary-400 animate-in delay-4 stagger-children">
                                <div class="flex items-center gap-2">
                                    <span class="h-1.5 w-1.5 rounded-full bg-success"></span>
                                    Insights personalizados por IA
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-1.5 w-1.5 rounded-full bg-info"></span>
                                    Relatórios dinâmicos em 1 clique
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-1.5 w-1.5 rounded-full bg-danger"></span>
                                    Segurança com criptografia avançada
                                </div>
                            </div>
                        </div>

                        <div class="relative fade-in" data-animate style="animation-delay: 0.5s;">
                            <div class="absolute -top-10 -left-10 hidden lg:block h-32 w-32 rounded-3xl bg-white/40 blur-3xl dark:bg-primary-800/40" data-parallax="0.1"></div>
                            <div class="card-glass relative p-6 sm:p-8 shadow-apple-lg hover-scale">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-primary-500 dark:text-primary-400">Saldo do mês</p>
                                        <p class="mt-2 text-3xl font-semibold text-primary-900 dark:text-primary-50" id="balance-counter">R$ 8.420,32</p>
                                    </div>
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-success/15">
                                        <x-icons.trending-up class="w-6 h-6 text-success" />
                                    </div>
                                </div>
                                <div class="mt-8 grid gap-4 sm:grid-cols-2 stagger-children">
                                    <div class="rounded-2xl bg-primary-50/80 p-5 dark:bg-primary-900/70 hover-lift transaction-item">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="text-xs font-medium text-success/80">Receitas</span>
                                                <p class="mt-2 text-xl font-semibold text-primary-900 dark:text-primary-50">R$ 12.300</p>
                                            </div>
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-xs dark:bg-primary-800">
                                                <x-icons.plus-circle class="w-5 h-5 text-success" />
                                            </div>
                                        </div>
                                        <div class="mt-4 flex items-center gap-2 text-xs text-primary-500 dark:text-primary-400">
                                            <x-icons.trending-up class="w-4 h-4 text-success" />
                                            +18% vs mês anterior
                                        </div>
                                    </div>
                                    <div class="rounded-2xl bg-primary-50/80 p-5 dark:bg-primary-900/70 hover-lift transaction-item">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="text-xs font-medium text-danger/80">Gastos</span>
                                                <p class="mt-2 text-xl font-semibold text-primary-900 dark:text-primary-50">R$ 3.880</p>
                                            </div>
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-xs dark:bg-primary-800">
                                                <x-icons.trending-down class="w-5 h-5 text-danger" />
                                            </div>
                                        </div>
                                        <div class="mt-4 flex items-center gap-2 text-xs text-primary-500 dark:text-primary-400">
                                            <x-icons.clock class="w-4 h-4" />
                                            Alertas preventivos ativos
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 rounded-2xl border border-primary-100/60 p-5 dark:border-primary-800 hover-lift">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-primary-500 dark:text-primary-300">Categorias com maior gasto</p>
                                            <p class="mt-3 text-sm text-primary-500 dark:text-primary-400">Assinaturas • Alimentação • Mobilidade</p>
                                        </div>
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 dark:bg-primary-800">
                                            <x-icons.chart class="w-5 h-5 text-primary-600 dark:text-primary-300" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white/80 dark:bg-primary-900/40 border-y border-white/50 dark:border-primary-900/30">
                    <div class="max-w-6xl mx-auto px-6 sm:px-8 py-20">
                        <div class="flex flex-col gap-4 text-center fade-in" data-animate>
                            <span class="text-sm font-medium uppercase tracking-[0.3em] text-primary-400">Por que FinanceAI?</span>
                            <h2 class="text-3xl font-semibold text-primary-950 dark:text-primary-50">Minimalismo que se traduz em clareza financeira</h2>
                            <p class="max-w-3xl mx-auto text-primary-600 dark:text-primary-300">
                                Todos os recursos que você precisa, sem distrações. Criamos uma experiência fluida com base na mesma linguagem visual do dashboard para que a mudança entre páginas seja natural.
                            </p>
                        </div>
                        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 stagger-children" data-animate>
                            <div class="card-minimal p-6 space-y-4 hover-lift">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 dark:bg-primary-800">
                                    <x-icons.list class="w-5 h-5 text-primary-600 dark:text-primary-300" />
                                </div>
                                <h3 class="text-lg font-semibold">Planejamento estruturado</h3>
                                <p class="text-sm leading-relaxed text-primary-500 dark:text-primary-400">
                                    Categorize receitas e despesas em segundos e acompanhe metas com indicadores de performance em tempo real.
                                </p>
                            </div>
                            <div class="card-minimal p-6 space-y-4 hover-lift">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-success/15">
                                    <x-icons.filter class="w-5 h-5 text-success" />
                                </div>
                                <h3 class="text-lg font-semibold">Insights acionáveis</h3>
                                <p class="text-sm leading-relaxed text-primary-500 dark:text-primary-400">
                                    Detecte padrões com nossa IA e receba sugestões automáticas para reduzir gastos e aproveitar oportunidades.
                                </p>
                            </div>
                            <div class="card-minimal p-6 space-y-4 hover-lift">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-info/15">
                                    <x-icons.search class="w-5 h-5 text-info" />
                                </div>
                                <h3 class="text-lg font-semibold">Transparência total</h3>
                                <p class="text-sm leading-relaxed text-primary-500 dark:text-primary-400">
                                    Relatórios precisos, visualizações limpas e filtros avançados para entender cada movimento em segundos.
                                </p>
                            </div>
                            <div class="card-minimal p-6 space-y-4 hover-lift">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-danger/15">
                                    <x-icons.clock class="w-5 h-5 text-danger" />
                                </div>
                                <h3 class="text-lg font-semibold">Alertas inteligentes</h3>
                                <p class="text-sm leading-relaxed text-primary-500 dark:text-primary-400">
                                    Receba notificações antes que oscilações impactem seu orçamento. Reações rápidas com base em dados confiáveis.
                                </p>
                            </div>
                            <div class="card-minimal p-6 space-y-4 hover-lift">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 dark:bg-primary-800">
                                    <x-icons.moon class="w-5 h-5 text-primary-600 dark:text-primary-300" />
                                </div>
                                <h3 class="text-lg font-semibold">Dark mode elegante</h3>
                                <p class="text-sm leading-relaxed text-primary-500 dark:text-primary-400">
                                    Comutação automática entre temas claro e escuro para acompanhar o dashboard sem cansar a visão.
                                </p>
                            </div>
                            <div class="card-minimal p-6 space-y-4 hover-lift">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 dark:bg-primary-800">
                                    <x-icons.settings class="w-5 h-5 text-primary-600 dark:text-primary-300" />
                                </div>
                                <h3 class="text-lg font-semibold">Segurança de ponta a ponta</h3>
                                <p class="text-sm leading-relaxed text-primary-500 dark:text-primary-400">
                                    Dados protegidos com criptografia e autenticação reforçada para manter suas informações sob controle.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="max-w-6xl mx-auto px-6 sm:px-8 py-20">
                    <div class="grid gap-12 lg:grid-cols-[1.1fr_1fr] items-center">
                        <div class="space-y-6 fade-in" data-animate>
                            <h3 class="text-2xl font-semibold">Conectado ao seu cotidiano financeiro</h3>
                            <p class="text-primary-600 dark:text-primary-300">
                                A mesma estética minimalista do dashboard permeia todos os fluxos de navegação. Listas leves, cards com microinterações e tipografia precisa entregam uma experiência agradável em qualquer dispositivo.
                            </p>
                            <ul class="space-y-4 text-sm text-primary-500 dark:text-primary-400 stagger-children">
                                <li class="flex items-center gap-3 hover-lift">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-primary-100 dark:bg-primary-800">
                                        <x-icons.home class="w-4 h-4 text-primary-600 dark:text-primary-300" />
                                    </span>
                                    Dashboard com visão consolidada por mês e categoria
                                </li>
                                <li class="flex items-center gap-3 hover-lift">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-success/15">
                                        <x-icons.plus class="w-4 h-4 text-success" />
                                    </span>
                                    Criador de transações guiado com validação inteligente
                                </li>
                                <li class="flex items-center gap-3 hover-lift">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-info/15">
                                        <x-icons.chart class="w-4 h-4 text-info" />
                                    </span>
                                    Relatórios customizáveis com exportação em 1 clique
                                </li>
                            </ul>
                        </div>
                        <div class="card-minimal relative overflow-hidden rounded-3xl border border-white/60 p-8 shadow-apple-lg dark:border-primary-900/40 hover-scale fade-in" data-animate style="animation-delay: 0.3s;">
                            <div class="absolute -top-24 right-0 h-40 w-40 rounded-full bg-info/10 blur-3xl" data-parallax="0.1"></div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-primary-500 dark:text-primary-300">Resumo semanal</p>
                                    <p class="mt-3 text-2xl font-semibold">R$ 2.140 de economia</p>
                                </div>
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-900 text-white dark:bg-primary-100 dark:text-primary-900">
                                    <x-icons.chart class="w-6 h-6" />
                                </div>
                            </div>
                            <div class="mt-8 space-y-5">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-primary-500 dark:text-primary-400">Meta mensal</span>
                                    <span class="font-medium text-success">82% concluída</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-primary-100 dark:bg-primary-800">
                                    <div class="h-full w-4/5 rounded-full bg-success progress-bar" style="width: 0%;"></div>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-primary-500 dark:text-primary-400">Alertas resolvidos</span>
                                    <span class="font-medium text-info">12 neste mês</span>
                                </div>
                                <div class="flex flex-col gap-3 text-sm text-primary-500 dark:text-primary-400">
                                    <div class="flex justify-between hover-lift">
                                        <span>Assinaturas</span>
                                        <span class="font-medium">-12%</span>
                                    </div>
                                    <div class="flex justify-between hover-lift">
                                        <span>Transporte</span>
                                        <span class="font-medium">-8%</span>
                                    </div>
                                    <div class="flex justify-between hover-lift">
                                        <span>Restaurantes</span>
                                        <span class="font-medium text-danger">+4%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="relative py-20">
                    <div class="max-w-4xl mx-auto px-6 sm:px-8 text-center">
                        <div class="rounded-3xl border border-primary-100/70 bg-white/80 p-10 shadow-apple-lg backdrop-blur-xl dark:border-primary-900/40 dark:bg-primary-900/60 hover-scale fade-in" data-animate>
                            <p class="text-sm font-medium uppercase tracking-[0.25em] text-primary-400">Pronto para começar?</p>
                            <h3 class="mt-6 text-3xl font-semibold text-primary-950 dark:text-primary-50">Modernize sua relação com o dinheiro hoje mesmo</h3>
                            <p class="mt-4 text-primary-600 dark:text-primary-300">
                                Conecte-se ao FinanceAI e tenha acesso instantâneo ao ecossistema completo: dashboard minimalista, relatórios inteligentes, dark mode e uma UX que realmente guia suas próximas decisões.
                            </p>
                            <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                                @guest
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn-primary">Criar conta gratuita</a>
                                    @endif
                                    <a href="{{ route('login') }}" class="btn-secondary">Fazer login</a>
                                @else
                                    <a href="{{ url('/dashboard') }}" class="btn-primary">Voltar ao dashboard</a>
                                    <a href="{{ route('reports.index') }}" class="btn-secondary">Explorar relatórios</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="border-t border-white/50 bg-white/70 py-10 text-sm text-primary-500 backdrop-blur-xl dark:border-primary-900/40 dark:bg-primary-950">
                <div class="max-w-6xl mx-auto px-6 sm:px-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3 text-primary-600 dark:text-primary-300">
                        <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-primary-900 text-white font-semibold dark:bg-primary-100 dark:text-primary-900">F</span>
                        <span>FinanceAI • Assistente financeiro inteligente</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-primary-400">
                        <span>Design minimalista inspirado no dashboard</span>
                        <span>Privacidade e segurança em primeiro lugar</span>
                        <span>Atualizado {{ now()->format('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            // Animar contador na landing page
            document.addEventListener('DOMContentLoaded', function() {
                const counter = document.getElementById('balance-counter');
                if (counter) {
                    let start = 0;
                    const end = 8420.32;
                    const duration = 2000;
                    const startTime = performance.now();

                    function updateCounter(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const current = start + (end - start) * progress;

                        counter.textContent = `R$ ${current.toLocaleString('pt-BR', {
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
                    }, 1000);
                }

                // Animar barra de progresso
                const progressBar = document.querySelector('.progress-bar');
                if (progressBar) {
                    setTimeout(() => {
                        progressBar.style.transition = 'width 2s ease-out';
                        progressBar.style.width = '82%';
                    }, 2000);
                }
            });
        </script>
    </body>
</html>
