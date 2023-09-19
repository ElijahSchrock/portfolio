@props([
    'disabled' => false,
])

<div class="flex  w-full">
    
    <input {{ $disabled ? 'disabled' : '' }} type="text" {!! $attributes->merge(['class' => 'flex-1 border-0 bg-slate-800 py-1.5 pl-1 focus:ring-0 sm:text-sm sm:leading-6 bg-slate-800 rounded-md text-slate-400']) !!}/>
</div>