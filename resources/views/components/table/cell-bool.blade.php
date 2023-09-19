@props([
    'value' => false, 
    'trueColor' => 'green', 
    'falseColor' => 'gray', 
    'trueIcon' => 'fas-circle', 
    'falseIcon' => 'far-circle',
    'nofalse' => false,
    'top' => false,
    'width' => 'w-3'
])

@php
switch ($trueColor) {
    case 'green':
        $trueColor = 'text-green-500';
        break;
    case 'blue':
        $trueColor = 'text-blue-400';
        break;
    case 'red':
        $trueColor = 'text-red-500';
        break;
    case 'yellow':
        $trueColor = 'text-yellow-500';
        break;
    case 'indigo':
        $trueColor = 'text-indigo-500';
        break;
    case 'gray':
        $trueColor = 'text-gray-500';
        break;
    default:
        $trueColor = 'text-green-500';
        break;
}

switch ($falseColor) {
    case 'gray':
        $falseColor = 'text-gray-300';
        break;
    case 'red':
        $falseColor = 'text-red-500';
        break;
    default:
        $falseColor = 'text-gray-300';
        break;
}



$topClass = $top ? ' align-top ' : '';
@endphp

<x-table.cell {{ $attributes }} class="{{ $topClass }}">
    @if($value)
    <x-dynamic-component :component="$trueIcon" class="{{ $width }} {{ $trueColor }}" />
    @else
        @if(!$nofalse)
        <x-dynamic-component :component="$falseIcon" class="{{ $width }} {{ $falseColor }}" />
        @endif
    @endif
</x-table.cell>