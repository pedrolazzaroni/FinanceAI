@props(['size' => 'default', 'class' => ''])

@php
$sizes = [
    'sm' => 'w-8 h-8',
    'default' => 'w-12 h-12',
    'lg' => 'w-16 h-16',
    'xl' => 'w-20 h-20',
    '2xl' => 'w-24 h-24'
];

$logoSize = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="relative {{ $logoSize }} {{ $class }}">
    <!-- Logo principal com gradiente -->
    <div class="relative w-full h-full bg-gradient-to-br from-primary-600 via-primary-500 to-success-500 rounded-2xl shadow-lg transform transition-all duration-300 hover:scale-110 hover:shadow-xl">
        <!-- Ícone principal: Gráfico de crescimento -->
        <svg class="absolute inset-2 text-white" fill="currentColor" viewBox="0 0 24 24">
            <!-- Base do gráfico -->
            <path d="M3 18h18v2H3v-2zm0-4h4v3H3v-3zm6-7h4v10H9V7zm6-4h4v14h-4V3z" opacity="0.8"/>
            <!-- Seta de crescimento -->
            <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z" opacity="0.9"/>
        </svg>

        <!-- Efeito de brilho -->
        <div class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent rounded-2xl"></div>
        
        <!-- Pontos decorativos -->
        <div class="absolute top-1 right-1 w-1.5 h-1.5 bg-white/60 rounded-full"></div>
        <div class="absolute bottom-1 left-1 w-1 h-1 bg-white/40 rounded-full"></div>
    </div>

    <!-- Shadow/glow effect -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-500/30 to-success-500/30 rounded-2xl blur-sm -z-10 opacity-50"></div>
</div>
