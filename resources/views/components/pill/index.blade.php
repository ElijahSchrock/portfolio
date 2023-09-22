@props(['color' => 'gray', 'label' => '', 'icon' => '', 'animated' => true])

@php
    $pillClasses = match ($color) {
            'gray' => 'bg-gray-200 text-gray-700',
            'red' => 'bg-[#e50914] text-white',
            'orange' => 'bg-orange-200 text-orange-700',
            'amber' => 'bg-amber-200 text-amber-700',
            'yellow' => 'bg-yellow-200 text-yellow-700',
            'lime' => 'bg-lime-200 text-lime-700',
            'green' => 'bg-green-200 text-green-700',
            'emerald' => 'bg-emerald-200 text-emerald-700',
            'teal' => 'bg-teal-200 text-teal-700',
            'sky' => 'bg-sky-200 text-sky-700',
            'indigo' => 'bg-indigo-200 text-indigo-700',
            'blue' => 'bg-blue-200 text-blue-700',
            'cyan' => 'bg-cyan-200 text-cyan-700',
            'pink' => 'bg-pink-200 text-pink-700',
            'rose' => 'bg-rose-200 text-rose-700',
            default => 'bg-gray-200 text-gray-700',
        };
@endphp

<div {{ $attributes->merge(['class' => "px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full $pillClasses "]) }}>
    @if($icon)
    <x-dynamic-component :component="$icon" class="w-3 h-3 mr-1 {{ $animated ? 'animate-spin-slow' : '' }}"  />
    @endif
    <span>{{ $label }}</span>
    {{ $slot }}
</div>
