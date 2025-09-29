@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-3 border-l-4 border-primary-900 text-primary-900 bg-primary-100 font-medium'
            : 'block w-full px-4 py-3 border-l-4 border-transparent text-primary-600 hover:text-primary-900 hover:bg-primary-50 hover:border-primary-300 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
