import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Sistema de dark mode global melhorado
window.darkModeManager = {
    init() {
        this.setInitialTheme();
        this.setupListeners();
        this.updateToggles();
    },
    
    setInitialTheme() {
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isDark = savedTheme === 'dark' || (!savedTheme && prefersDark);
        
        document.documentElement.classList.toggle('dark', isDark);
        document.body.classList.add('theme-transitioning');
        
        setTimeout(() => {
            document.body.classList.remove('theme-transitioning');
        }, 300);
        
        this.updateToggles();
    },
    
    toggle() {
        const isDark = document.documentElement.classList.contains('dark');
        
        document.body.classList.add('theme-transitioning');
        
        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
        
        this.updateToggles();
        
        setTimeout(() => {
            document.body.classList.remove('theme-transitioning');
        }, 300);
    },
    
    updateToggles() {
        const isDark = document.documentElement.classList.contains('dark');
        document.querySelectorAll('[id*="dark-mode-toggle"]').forEach(toggle => {
            toggle.setAttribute('aria-checked', isDark.toString());
        });
    },
    
    setupListeners() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('[id*="dark-mode-toggle"]')) {
                e.preventDefault();
                this.toggle();
            }
        });
    }
};

// Sistema de modais melhorado
window.modalManager = {
    activeModal: null,
    
    open(modalId) {
        console.log('Tentando abrir modal:', modalId);
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error('Modal não encontrado:', modalId);
            return;
        }
        
        // Fechar modal ativo se existir
        if (this.activeModal) {
            this.close(this.activeModal.id);
        }
        
        this.activeModal = modal;
        
        // Forçar estado inicial correto
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        
        // Força reflow para garantir que o display seja aplicado
        modal.offsetHeight;
        
        // Aplicar classe show
        modal.classList.add('show');
        
        // Bloquear scroll do body
        document.body.style.overflow = 'hidden';
        
        // Focus no primeiro input após um pequeno delay
        setTimeout(() => {
            const firstInput = modal.querySelector('input:not([type="hidden"]):not([readonly]):not([disabled]), select:not([disabled]), textarea:not([disabled])');
            if (firstInput) {
                firstInput.focus();
            }
        }, 150);
        
        console.log('Modal aberto com sucesso:', modalId);
    },
    
    close(modalId = null) {
        const modal = modalId ? document.getElementById(modalId) : this.activeModal;
        if (!modal) {
            console.log('Nenhum modal para fechar');
            return;
        }
        
        console.log('Fechando modal:', modal.id);
        
        // Remover classe show
        modal.classList.remove('show');
        modal.classList.add('hidden');
        
        // Aguardar transição antes de esconder completamente
        setTimeout(() => {
            modal.style.display = 'none';
        }, 200);
        
        // Restaurar scroll do body
        document.body.style.overflow = '';
        
        // Reset do modal
        this.resetModal(modal);
        
        // Limpar referência ativa
        if (this.activeModal === modal) {
            this.activeModal = null;
        }
        
        console.log('Modal fechado:', modal.id);
    },
    
    resetModal(modal) {
        // Reset formulário se existir
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
            
            // Reset visual state dos transaction type options
            modal.querySelectorAll('.transaction-type-option').forEach(option => {
                option.classList.remove('border-success', 'border-danger', 'bg-success/5', 'bg-danger/5');
                option.classList.add('border-primary-200', 'dark:border-primary-700');
                const radio = option.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            
            // Reset categoria select se existir
            const categorySelect = modal.querySelector('#modal_category_id, select[name="category_id"]');
            if (categorySelect) {
                categorySelect.innerHTML = '<option value="">Selecione uma categoria</option>';
            }
        }
        
        // Limpar erros de validação se existirem
        modal.querySelectorAll('.form-error').forEach(error => {
            error.textContent = '';
        });
        
        modal.querySelectorAll('.border-red-300, .border-red-500').forEach(input => {
            input.classList.remove('border-red-300', 'border-red-500');
            input.classList.add('border-primary-200', 'dark:border-primary-700');
        });
    },
    
    init() {
        console.log('Inicializando sistema de modais...');
        
        // Garantir que todos os modais começem ocultos
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
            modal.classList.add('hidden');
            modal.classList.remove('show');
        });
        
        // Event listeners globais
        this.setupEventListeners();
        
        console.log('Sistema de modais inicializado');
    },
    
    setupEventListeners() {
        // Fechar modal ao clicar no backdrop
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-backdrop')) {
                const modal = e.target.closest('.modal');
                if (modal) {
                    this.close(modal.id);
                }
            }
        });
        
        // Fechar modal com ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.activeModal) {
                this.close(this.activeModal.id);
            }
        });
        
        // Prevenir propagação de cliques dentro do modal
        document.addEventListener('click', (e) => {
            if (e.target.closest('.modal-content')) {
                e.stopPropagation();
            }
        });
    }
};

// Funções para melhorar a experiência do usuário
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado, inicializando sistemas...');
    
    // Inicializar sistemas
    window.darkModeManager.init();
    window.modalManager.init();
    
    // Configurar melhorias de UX
    setupPageTransitions();
    setupScrollAnimations();
    setupNotifications();
    setupFormLoading();
    setupParallaxEffects();
    setupRippleEffects();
    
    console.log('Todos os sistemas inicializados');
});

// Transições suaves entre páginas melhoradas
function setupPageTransitions() {
    let isTransitioning = false;
    
    function performTransition(url) {
        if (isTransitioning) return;
        isTransitioning = true;
        
        // Adicionar overlay de loading mais sutil
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-white/80 dark:bg-primary-950/80 backdrop-blur-sm z-50 flex items-center justify-center transition-opacity duration-150';
        overlay.innerHTML = `
            <div class="flex flex-col items-center">
                <div class="w-5 h-5 border-2 border-primary-300 border-t-primary-900 dark:border-primary-700 dark:border-t-primary-100 rounded-full animate-spin mb-2"></div>
                <span class="text-xs text-primary-600 dark:text-primary-400">Carregando...</span>
            </div>
        `;
        
        overlay.style.opacity = '0';
        document.body.appendChild(overlay);
        
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
            
            setTimeout(() => {
                window.location.href = url;
            }, 80);
        });
    }
    
    // Event listeners para links internos
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[href]');
        if (!link) return;
        
        const href = link.getAttribute('href');
        
        // Verificar se é um link interno válido
        if (href && 
            !href.startsWith('#') && 
            !href.startsWith('mailto:') && 
            !href.startsWith('tel:') && 
            !href.startsWith('http') && 
            !link.hasAttribute('target') &&
            !link.hasAttribute('download') &&
            !link.classList.contains('no-transition') &&
            !link.closest('form')) {
            
            e.preventDefault();
            performTransition(href);
        }
    });
}

// Animações baseadas em scroll otimizadas
function setupScrollAnimations() {
    const observerOptions = {
        threshold: 0.02,
        rootMargin: '0px 0px -10px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                element.classList.add('animate-in');
                
                // Delay personalizado baseado em data-animate ou posição
                const delay = element.dataset.delay || 
                            (Array.from(element.parentNode.children).indexOf(element) * 30);
                
                if (delay > 0) {
                    element.style.animationDelay = delay + 'ms';
                }
                
                observer.unobserve(element);
            }
        });
    }, observerOptions);
    
    // Observar elementos com animações
    document.querySelectorAll('.fade-in, .slide-up, .scale-in, [data-animate]').forEach(el => {
        observer.observe(el);
    });
}

// Sistema de notificações
function setupNotifications() {
    // Auto-dismiss flash messages
    const flashMessages = document.querySelectorAll('[data-auto-dismiss]');
    flashMessages.forEach(message => {
        const delay = parseInt(message.dataset.autoDismiss) || 5000;
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transform = 'translateY(-8px)';
            setTimeout(() => {
                message.remove();
            }, 150);
        }, delay);
    });
}

// Loading states para formulários melhorados
function setupFormLoading() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitButton && !form.hasAttribute('data-no-loading')) {
                
                // Prevenir duplo submit
                if (submitButton.disabled) {
                    e.preventDefault();
                    return;
                }
                
                submitButton.disabled = true;
                submitButton.classList.add('loading');
                
                const originalContent = submitButton.innerHTML;
                
                submitButton.innerHTML = `
                    <div class="flex items-center justify-center">
                        <div class="spinner w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin mr-2"></div>
                        <span>Processando...</span>
                    </div>
                `;
                
                // Restaurar estado após timeout (fallback)
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.classList.remove('loading');
                    submitButton.innerHTML = originalContent;
                }, 8000);
            }
        });
    });
}

// Efeitos de parallax sutis otimizados
function setupParallaxEffects() {
    if (window.location.pathname === '/' && window.innerWidth > 768) {
        const parallaxElements = document.querySelectorAll('[data-parallax]');
        let ticking = false;
        
        function updateParallax() {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.parallax) || 0.5;
                const yPos = -(scrolled * speed);
                element.style.transform = `translate3d(0, ${yPos}px, 0)`;
            });
            
            ticking = false;
        }
        
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }, { passive: true });
    }
}

// Sistema de efeitos ripple melhorado
function setupRippleEffects() {
    function addRippleEffect(element) {
        element.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }
    
    // Aplicar efeito ripple aos botões principais
    document.querySelectorAll('.btn-primary, .btn-secondary').forEach(btn => {
        addRippleEffect(btn);
    });
}

// Smooth scroll para âncoras
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Lazy loading para imagens
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Melhorias específicas para mobile
if ('ontouchstart' in window) {
    // Adicionar classe para dispositivos touch
    document.documentElement.classList.add('touch-device');
    
    // Melhorar hover states em mobile
    document.addEventListener('touchstart', function() {}, { passive: true });
}
