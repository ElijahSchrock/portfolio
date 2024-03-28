<div>
    <div class="mx-auto max-w-7xl pt-4">
        <x-toolbar>
            <x-toolbar.flex />
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button type="button" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" wire:click="$dispatch('openModal', { component: 'edit-hero-card' })">Add Hero Card</button>
            </div>
        </x-toolbar>
    </div>
    <x-table>
        <x-slot name="head">
            <x-table.heading>Banner</x-table.heading>
            <x-table.heading>Logo</x-table.heading>
            <x-table.heading>Order</x-table.heading>
            <x-table.heading></x-table.heading>
        </x-slot>
        
        <x-slot name="body">
            <x-table.body>
                @foreach($this->heroCards as $_heroCard)
                    <x-table.row>
                        <x-table.cell>
                            <img class="w-32" src="{{ $_heroCard->getFirstMedia('heroCard')?->getURL() ?? null }}"/>
                        </x-table.cell>
                        <x-table.cell>
                            <img class="w-32" src="{{ $_heroCard->getFirstMedia('logo')?->getURL() ?? null }}"/>
                        </x-table.cell>
                        <x-table.cell >{{ $_heroCard->order }}</x-table.cell>
                        <x-table.cell-edit action="$dispatch('openModal', { component: 'edit-hero-card', arguments: { heroCard: {{ $_heroCard->id }} }})"/>
                        <x-table.cell-delete action="deleteCard({{ $_heroCard->id }})"/>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-slot>
    
    </x-table>
</div>
