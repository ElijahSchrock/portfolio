@props([
    'placeholder' => null,
    'plain' => false
])

<div class="flex">
  <select {{ $attributes->merge(['class' => 'bg-slate-800 text-slate-300 flex-1 input-focus-ring input-focus-border block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-700 focus:outline-none  sm:text-sm sm:leading-5 '. ($plain ? '' : 'rounded-md') ]) }}>
    @if ($placeholder)
        <option disabled value="">{{ $placeholder }}</option>
    @endif

    {{ $slot }}
  </select>
</div>