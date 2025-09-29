@props(['name', 'class' => 'w-5 h-5'])

@php
$iconPath = "components.icons.{$name}";
@endphp

@if(view()->exists($iconPath))
    <x-dynamic-component :component="icons.{$name}" {{ $attributes->merge(['class' => $class]) }} />
@else
    <svg {{ $attributes->merge(['class' => $class]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
@endif