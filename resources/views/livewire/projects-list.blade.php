<div>
    {{-- <div class="bg-slate-900">
        <div class="mx-auto max-w-7xl">
            <div class="bg-slate-900 py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-white">Projects</h1>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <button type="button" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Add user</button>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-slate-700">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-0">Image</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Name</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Description</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Showing</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800">
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">Lindsay Walton</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-300">Front-end Developer</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-300">lindsay.walton@example.com</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-300">Member</td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <a href="#" class="text-indigo-400 hover:text-indigo-300">Edit<span class="sr-only">, Lindsay Walton</span></a>
                                            </td>
                                        </tr>

                                        <!-- More people... -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
