@props([
    'icon' => null,
    'iconClasses' => '',
    'dropdown' => null,
    'disable' => false,
    'style' => '',
    ])

<div class="inline-flex flex-shrink-0 relative">
    <button
        {{ ($disable) ? "disabled=disabled" : "" }}
        {{ $attributes->merge([
            'type' => 'button',
            'class' => 'flex justify-center items-center space-x-2 py-2 px-3 rounded-md text-sm leading-5 disabled:cursor-not-allowed disabled:opacity-50 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2  transition duration-150 ease-in-out dark:text-slate-200' . ($attributes->get('disabled') || $disable ? ' opacity-50 cursor-not-allowed' : ''),
        ]) }}
    >
        @if($icon)<x-dynamic-component :component="$icon" class="w-4 h-4 {{ $animate ? 'animate-spin' : '' }} {{ $iconClasses }}" />@endif
        @if($slot->isNotEmpty())<div>{{ $slot }}</div>@endif
        
        @if($dropdown)
        <svg class="-mr-1 ml-2 h-5 w-5" x-description="Heroicon name: chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
        @endif

    </button>
</div>
