<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FinanceAI - Assistente Financeiro Inteligente</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { 
                    font-family: 'Poppins', system-ui, sans-serif; 
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    color: #333;
                }
                .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
                .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
                .hero-content { text-align: center; max-width: 800px; color: white; }
                .hero h1 { font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
                .hero p { font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9; }
                .btn { 
                    display: inline-block; 
                    padding: 15px 30px; 
                    margin: 10px; 
                    border-radius: 50px; 
                    text-decoration: none; 
                    font-weight: 600; 
                    transition: all 0.3s;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                }
                .btn-primary { background: #4CAF50; color: white; }
                .btn-secondary { background: rgba(255,255,255,0.2); color: white; border: 2px solid white; }
                .btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.3); }
                .features { background: white; padding: 80px 0; }
                .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-top: 50px; }
                .feature { text-align: center; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
                .feature-icon { font-size: 3rem; margin-bottom: 20px; }
                .feature h3 { font-size: 1.5rem; margin-bottom: 15px; color: #333; }
                .feature p { color: #666; line-height: 1.6; }
                .nav { 
                    position: fixed; 
                    top: 0; 
                    width: 100%; 
                    background: rgba(255,255,255,0.95); 
                    backdrop-filter: blur(10px); 
                    padding: 15px 0; 
                    z-index: 1000;
                    border-bottom: 1px solid rgba(0,0,0,0.1);
                }
                .nav-content { display: flex; justify-content: space-between; align-items: center; }
                .logo { font-size: 1.5rem; font-weight: 700; color: #667eea; }
                .nav-links { display: flex; gap: 20px; align-items: center; }
                .nav-links a { 
                    text-decoration: none; 
                    color: #333; 
                    font-weight: 500; 
                    padding: 10px 20px; 
                    border-radius: 25px; 
                    transition: all 0.3s;
                }
                .nav-links a:hover { background: #667eea; color: white; }
                @media (max-width: 768px) {
                    .hero h1 { font-size: 2.5rem; }
                    .hero p { font-size: 1rem; }
                    .features-grid { grid-template-columns: 1fr; }
                    .nav-links { flex-direction: column; gap: 10px; }
                }
            </style>
        @endif
    </head>
    <body>
        <!-- Navigation -->
        <nav class="nav">
            <div class="container">
                <div class="nav-content">
                    <div class="logo">💰 FinanceAI</div>
                    @if (Route::has('login'))
                        <div class="nav-links">
                            @auth
                                <a href="{{ url('/dashboard') }}">🏠 Meu Dashboard</a>
                            @else
                                <a href="{{ route('login') }}">Entrar</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Criar Conta</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>🏦 FinanceAI</h1>
                    <p>Seu assistente financeiro inteligente que ajuda você a tomar decisões mais inteligentes com seu dinheiro usando o poder da Inteligência Artificial</p>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">🚀 Acessar Dashboard</a>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">📊 Ver Relatórios</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">🆕 Começar Gratuitamente</a>
                        <a href="{{ route('login') }}" class="btn btn-secondary">📱 Fazer Login</a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <div style="text-align: center;">
                    <h2 style="font-size: 2.5rem; margin-bottom: 20px; color: #333;">✨ Recursos Incríveis</h2>
                    <p style="font-size: 1.2rem; color: #666; max-width: 600px; margin: 0 auto;">Gerencie suas finanças de forma inteligente com ferramentas modernas e análises baseadas em IA</p>
                </div>

                <div class="features-grid">
                    <div class="feature">
                        <div class="feature-icon">💰</div>
                        <h3>Gestão Completa</h3>
                        <p>Controle total de receitas e gastos com categorização inteligente e interface intuitiva</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">🤖</div>
                        <h3>Inteligência Artificial</h3>
                        <p>Análises personalizadas e recomendações inteligentes baseadas nos seus padrões financeiros</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">📊</div>
                        <h3>Relatórios Detalhados</h3>
                        <p>Visualize sua evolução financeira com gráficos e relatórios de fácil compreensão</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">🎯</div>
                        <h3>Categorias Inteligentes</h3>
                        <p>Organize automaticamente seus gastos em categorias visuais e funcionais</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">📱</div>
                        <h3>Interface Moderna</h3>
                        <p>Design responsivo e intuitivo que funciona perfeitamente em qualquer dispositivo</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">🔒</div>
                        <h3>Seguro e Privado</h3>
                        <p>Seus dados financeiros ficam protegidos com criptografia de alto nível</p>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 60px;">
                    @guest
                        <h3 style="margin-bottom: 30px; color: #333;">🚀 Pronto para transformar suas finanças?</h3>
                        <a href="{{ route('register') }}" class="btn btn-primary" style="background: linear-gradient(45deg, #4CAF50, #45a049);">
                            ✨ Criar Conta Gratuita
                        </a>
                    @else
                        <h3 style="margin-bottom: 30px; color: #333;">🎉 Bem-vindo de volta, {{ Auth::user()->name }}!</h3>
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="background: linear-gradient(45deg, #667eea, #764ba2);">
                            📈 Continuar Gerenciando
                        </a>
                    @endguest
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer style="background: #333; color: white; text-align: center; padding: 40px 0;">
            <div class="container">
                <p style="margin-bottom: 10px;">💰 <strong>FinanceAI</strong> - Seu assistente financeiro inteligente</p>
                <p style="opacity: 0.7;">Desenvolvido com ❤️ usando tecnologias modernas</p>
            </div>
        </footer>
    </body>
</html>