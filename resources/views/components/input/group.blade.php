@props([
    'label',
    'for',
    'error' => false,
    'helpText' => false,
    'inline' => false,
    'required' => false
])

@if($inline)

    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200">
        <label for="{{ $for }}" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200 sm:mt-px sm:pt-2 @if($required) after:content-['*'] after:ml-0.5 after:text-red-500 @endif">
            {{ $label }}
        </label>

        <div class="mt-0.5 sm:mt-0 sm:col-span-2">
            {{ $slot }}

            @if ($error)
                @error($error)
                    <p {{ $attributes->merge(['class' => 'mt-1 text-sm text-red-600']) }}>{{ $message }}</p>
                @enderror
            @endif

            @if ($helpText)
                <p class="mt-0.5 text-sm text-gray-500">{{ $helpText }}</p>
            @endif
        </div>
    </div>

    
@else
    
    <div>
        <div class="flex justify-between group">
            <label for="{{ $for }}" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-200 @if($required) after:content-['*'] after:ml-0.5 after:text-red-500 @endif">{{ $label }}</label>
            @isset($labelButton)
                {{ $labelButton }}
            @endisset
        </div>
        
        
        <div class="relative mt-0.5 rounded-md">
            {{ $slot }}

            @if ($error)
                @error($error)
                    <p {{ $attributes->merge(['class' => 'mt-1 text-sm text-red-600']) }}>{{ $message }}</p>
                @enderror
            @endif

            @if ($helpText)
                <p class="mt-1 text-sm text-gray-500 dark:text-slate-200">{{ $helpText }}</p>
            @endif
        </div>
    </div>

@endif
