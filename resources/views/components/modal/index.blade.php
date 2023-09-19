{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

@props(['id', 'maxWidth'])

@php
$id = $id ?? md5($attributes->wire('model'));

switch ($maxWidth ?? '2xl') {
case 'sm':
$maxWidth = 'sm:max-w-sm';
break;
case 'md':
$maxWidth = 'sm:max-w-md';
break;
case 'lg':
$maxWidth = 'sm:max-w-lg';
break;
case 'xl':
$maxWidth = 'sm:max-w-xl';
break;
case '3xl':
$maxWidth = 'sm:max-w-3xl';
break;
case '4xl':
$maxWidth = 'sm:max-w-4xl';
break;
case '5xl':
$maxWidth = 'sm:max-w-5xl';
break;
case '2xl':
default:
$maxWidth = 'sm:max-w-2xl';
break;
}
@endphp

<div x-data="{
        show: @entangle($attributes->wire('model')),
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input, textarea, select, details, .choices, .choices__inner, [tabindex]:not([tabindex=\'-1\'])'
            
            let els =  [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
                .filter(el => el.tabIndex != -1)
                .filter(el => ! el.classList.contains('choices__input'))
                .filter(el => ! el.classList.contains('choices__button'));
            
            return els;
            
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { console.log(this.focusables()); return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
        autofocus() { let focusable = $el.querySelector('[autofocus]'); if (focusable) focusable.focus() },
    }" x-init="$watch('show', value => value && setTimeout(autofocus, 50));" 
        x-on:close.stop="show = false" 
        x-on:keydown.escape.window="show = false" 
        x-on:keydown.tab="$event.preventDefault(); $event.shiftKey || nextFocusable().focus();"
        x-on:keydown.shift.tab.prevent="prevFocusable().focus()" 
        x-show="show" 
        id="{{ $id }}" 
        class="fixed z-10 inset-0 overflow-y-auto" 
        style="display: none;">



        
    <div class="flex items-start justify-center min-h-screen pt-4 px-4 pb-4 text-center sm:block ">
        <!-- background -->
        <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" 
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        {{-- removed overflow-hidden to allow dropdown at bottom to overhang --}}
        <div x-show="show" class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left  shadow-xl transform transition-all sm:my-8 sm:align-middle  w-full {{ $maxWidth }}" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            {{ $slot }}
        </div>

    </div>
</div>
