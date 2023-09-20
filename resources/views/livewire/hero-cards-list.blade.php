{{-- <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl p-6">
        <div class="">
            <form wire:submit.prevent="save">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-white">Create a New Hero Card</h2>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <div class="mt-2">
                                    <x-input.group for="description" label="Description" error="description">
                                        <x-input.textarea wire:model="description" id="description" rows="3" placeholder="Enter Project Description" />
                                    </x-input.group>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input.group for="logo_upload" label="Hero Card Logo Upload" error="logo">
                                    @unless ($logo)
                                    <x-input.file-upload label="Upload a file" for="logo_upload">
                                        <input id="logo_upload" name="logo_upload" type="file" wire:model="logo" class="sr-only">
                                    </x-input.file-upload>
                                    @else
                                    <div class="space-y-4" wire:loading.class="opacity-25" wire:loading.attr="disabled">
                                        <div class="text-sm font-bold text-slate-300 space-y-2 p-3 rounded-md bg-slate-800 border border-slate-700 shadow-sm">
                                            <div class="flex justify-between">
                                                <div>{{ $logo->getClientOriginalName() }}</div>
                                                <button type="button" class="flex items-center space-x-2 text-gray-400 hover:text-slate-500 text-sm leading-5 font-medium focus:outline-none focus:underline transition duration-150 ease-in-out" wire:click="removeFile('logo')">
                                                    <x-dynamic-component component="fas-trash-can" class="h-4 w-4" />
                                                    Remove File
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading class="text-sm py-2 text-gray-400">
                                        Please wait...
                                    </div>
                                    @endif
                                </x-input.group>
                            </div>

                            <div class="col-span-full border-b border-white/10">
                            </div>

                            <div class="col-span-full">
                                <p class="mb-4 text-sm font-medium leading-6 text-white">Attach a Banner to the Hero Card Logo</p>
                                <x-input.group for="hero_card" label="Hero Card Upload" error="heroCard">
                                    @unless ($heroCard)
                                    <x-input.file-upload label="Upload a file" for="hero_card">
                                        <input id="hero_card" name="hero_card" type="file" wire:model="heroCard" class="sr-only">
                                    </x-input.file-upload>
                                    @else
                                    <div class="space-y-4" wire:loading.class="opacity-25" wire:loading.attr="disabled">
                                        <div class="text-sm font-bold text-slate-300 space-y-2 p-3 rounded-md bg-slate-800 border border-slate-700 shadow-sm">
                                            <div class="flex justify-between">
                                                <div>{{ $heroCard->getClientOriginalName() }}</div>
                                                <button type="button" class="flex items-center space-x-2 text-gray-400 hover:text-slate-500 text-sm leading-5 font-medium focus:outline-none focus:underline transition duration-150 ease-in-out" wire:click="removeFile('heroCard')">
                                                    <x-dynamic-component component="fas-trash-can" class="h-4 w-4" />
                                                    Remove File
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading class="text-sm py-2 text-gray-400">
                                        Please wait...
                                    </div>
                                    @endif
                                </x-input.group>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm font-semibold leading-6 text-white">Cancel</button>
                        <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div> --}}
<div>
    <x-table>
       
        <x-slot name="head">
            <x-table.heading>Banner</x-table.heading>
            <x-table.heading>Logo</x-table.heading>
            <x-table.heading class="hidden sm:table-cell">Description</x-table.heading>
            <x-table.heading>Order</x-table.heading>
            <x-table.heading></x-table.heading>
        </x-slot>
        
        <x-slot name="body">
            <x-table.body>
                @foreach($heroCards as $heroCard)
                    <x-table.row>
                        <x-table.cell>
                            <img class="w-32" src="{{ $heroCard->getFirstMedia('heroCard')?->getURL() ?? null }}"/>
                        </x-table.cell>
                        <x-table.cell>
                            <img class="w-32" src="{{ $heroCard->getFirstMedia('logo')?->getURL() ?? null }}"/>
                        </x-table.cell>
                        <x-table.cell class="hidden sm:table-cell">{{ $heroCard->description }}</x-table.cell>
                        <x-table.cell >{{ $heroCard->order ?? rand(1, 10) }}</x-table.cell>
                        <x-table.cell-edit action="$dispatch('openModal', { component: 'edit-project', arguments: { project: {{ $heroCard->id }} }})"/>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-slot>
    
    </x-table>
</div>
