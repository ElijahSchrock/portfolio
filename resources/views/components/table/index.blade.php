@props([
    'label' => '',
    'addButton' => false,
    'adding' => '',
])

<div class="bg-slate-900">
    <div class="mx-auto max-w-7xl">
        <div class="bg-slate-900 pb-10">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-white">{{ $label }}</h1>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        @if($addButton)
                        <button type="button" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Add {{ $adding }}</button>
                        @endif
                    </div>
                </div>
                <div class="mt-5 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-slate-700">
                                <thead>
                                    <tr>
                                        {{ $head }}
                                    </tr>
                                </thead>
                                {{ $body }}
                                @isset($footer)
                                    <tfoot {{ $footer->attributes->merge(['class' => '']) }}>
                                        {{ $footer }}
                                    </tfoot>
                                @endisset
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
