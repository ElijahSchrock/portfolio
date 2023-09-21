<form wire:submit.prevent="save">
    <x-modal.livewire-ui>
        <x-slot name="title">{{ $project->getKey() ? 'Edit' : 'New' }} Project</x-slot>
        <x-slot name="content">
            <x-input.group for="project_name" label="Name" error="project.name">
                <x-input.text wire:model="project.name" id="project_name" placeholder="" />
            </x-input.group>
            <x-input.group for="project_description" label="Description" error="project.description">
                <x-input.text wire:model="project.description" id="project_description" placeholder="" />
            </x-input.group>
        </x-slot>
        <x-slot name="footer">
            <x-toolbar>
                <x-input.checkbox wire:model="project.showing" id="project_showing" for="project_showing" boxLabel="Show this project?" />
                <x-toolbar.flex />
                <x-button type="button" class="bg-gray-700 hover:bg-gray-600" wire:click="closeModal()">Close</x-button>
                <x-button type="submit" class="bg-blue-800 hover:bg-blue-600">save</x-button>
            </x-toolbar>
        </x-slot>
    </x-modal.livewire-ui>
</form>
