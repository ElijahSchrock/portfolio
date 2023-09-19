@props([
    'disabled' => false,
])
<div class="flex rounded-md">
    <textarea {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'flex-1 focus:ring-0 block w-full transition duration-150 shadow-sm sm:text-sm rounded-md bg-slate-800 text-slate-400 border-none']) }}>
        {{ $slot }}
    </textarea>
</div>
