
@props([
    'closeButton' => true, 'closeAction' => 'closeModal'
])

<div class="bg-white dark:bg-slate-900" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg dark:text-slate-300 flex justify-between border-b pb-2 items-center">
            {{ $title }}
            @if($closeButton)
            <button wire:click="{{ $closeAction }}" type="button" class="p-1   text-gray-400 hover:text-gray-500 transition ease-in-out duration-150 text-3xl outline-none ">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            @endif
        </div>

        <div class="mt-4 text-slate-400">
            {{ $content }}
        </div>
    </div>

    <div class="bg-gray-100 dark:bg-slate-800 py-1 px-2">
        {{ $footer }}
    </div>
    
</div>
