<div>
    <x-table>
       
        <x-slot name="head">
            <x-table.heading>Image</x-table.heading>
            <x-table.heading>Name</x-table.heading>
            <x-table.heading class="hidden sm:table-cell">Description</x-table.heading>
            <x-table.heading>Showing</x-table.heading>
            <x-table.heading></x-table.heading>
        </x-slot>
        
        <x-slot name="body">
            <x-table.body>
                @foreach($projects as $project)
                    <x-table.row>
                        <x-table.cell>
                            <img class="w-32" src="{{ $project->getFirstMedia('images')?->getURL() ?? null }}"/>
                        </x-table.cell>
                        <x-table.cell>{{ $project->name }}</x-table.cell>
                        <x-table.cell class="hidden sm:table-cell">{{ $project->description }}</x-table.cell>
                        <x-table.cell-bool :value="$project->showing"/>
                        <x-table.cell-edit action="$dispatch('openModal', { component: 'edit-project', arguments: { project: {{ $project->id }} }})"/>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-slot>
    
    </x-table>
</div>
