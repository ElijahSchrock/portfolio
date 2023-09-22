@props(['color' => 'gray'])

@php
    $classes = match ($color) {
            'gray' => 'text-gray-400 hover:bg-gray-300 hover:text-gray-500 focus:outline-none focus:bg-gray-300',
            'red' => 'text-red-400 hover:bg-red-300 hover:text-red-500 focus:outline-none focus:bg-red-300',
            'orange' => 'text-orange-400 hover:bg-orange-300 hover:text-orange-500 focus:outline-none focus:bg-orange-300',
            'amber' => 'text-amber-400 hover:bg-amber-300 hover:text-amber-500 focus:outline-none focus:bg-amber-300',
            'yellow' => 'text-yellow-400 hover:bg-yellow-300 hover:text-yellow-500 focus:outline-none focus:bg-yellow-300',
            'lime' => 'text-lime-400 hover:bg-lime-300 hover:text-lime-500 focus:outline-none focus:bg-lime-300',
            'green' => 'text-green-400 hover:bg-green-300 hover:text-green-500 focus:outline-none focus:bg-green-300',
            'emerald' => 'text-emerald-400 hover:bg-emerald-300 hover:text-emerald-500 focus:outline-none focus:bg-emerald-300',
            'teal' => 'text-teal-400 hover:bg-teal-300 hover:text-teal-500 focus:outline-none focus:bg-teal-300',
            'sky' => 'text-sky-400 hover:bg-sky-300 hover:text-sky-500 focus:outline-none focus:bg-sky-300',
            'indigo' => 'text-indigo-400 hover:bg-indigo-300 hover:text-indigo-500 focus:outline-none focus:bg-indigo-300',
            'blue' => 'text-blue-400 hover:bg-blue-300 hover:text-blue-500 focus:outline-none focus:bg-blue-300',
            'cyan' => 'text-cyan-400 hover:bg-cyan-300 hover:text-cyan-500 focus:outline-none focus:bg-cyan-300',
            'pink' => 'text-pink-400 hover:bg-pink-300 hover:text-pink-500 focus:outline-none focus:bg-pink-300',
            'rose' => 'text-rose-400 hover:bg-rose-300 hover:text-rose-500 focus:outline-none focus:bg-rose-300',
            default => 'text-gray-400 hover:bg-orange-300 hover:text-orange-500 focus:outline-none focus:bg-orange-300',
        };
@endphp

<button {{ $attributes->merge(['class' => "flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center focus:outline-none $classes"]) }} type="button" >
    <x-fas-times class="w-3 h-3" />
</button>