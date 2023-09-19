@props(['boxLabel' => null, 'for' => '', 'size' => 'base', 'disabled' => false])

@php
    $sizeClasses = match ($size) {
        'sm' => 'h-3 w-3',
        'base' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-6 w-6',
        default => 'h-4 w-4'
    };
@endphp
<div class="flex">
    <input {{ $attributes->class(['input-text-color input-focus-ring' => true])->merge(['class' => $sizeClasses . '  border-gray-300 rounded dark:bg-gray-900 dark:border-gray-600'.($attributes->get('disabled') ? ' opacity-50 cursor-not-allowed' : '').($disabled ? ' opacity-50 cursor-not-allowed' : '')]) }}
        type="checkbox"
        {{ $disabled ? 'disabled' : '' }}
    />
    @if($boxLabel)
    <label for="{{ $for }}" class="text-sm -mt-0.5 ml-2 dark:text-gray-400">{{ $boxLabel }}</label>
    @endif
</div>
