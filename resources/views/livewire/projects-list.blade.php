<div>
    <div class="mx-auto max-w-7xl pt-4">
        <x-toolbar>
            <x-toolbar.flex />
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button type="button" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Add Project</button>
            </div>
        </x-toolbar>
    </div>
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
                        <img class="w-32" src="{{ $project->getFirstMedia('images')?->getURL() ?? null }}" />
                    </x-table.cell>
                    <x-table.cell>{{ $project->name }}</x-table.cell>
                    <x-table.cell class="hidden sm:table-cell whitespace-pre-wrap">{{ $project->description }}</x-table.cell>
                    <x-table.cell-bool :value="$project->showing" />
                    <x-table.cell-edit action="$dispatch('openModal', { component: 'edit-project', arguments: { project: {{ $project->id }} }})" />
                    <x-table.cell-delete action="deleteProject({{ $project->id }})"/>
                </x-table.row>
                @endforeach
            </x-table.body>
        </x-slot>

    </x-table>
</div>
