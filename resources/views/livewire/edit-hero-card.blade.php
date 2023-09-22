<form wire:submit.prevent="save">
    <x-modal.livewire-ui>
        <x-slot name="title">{{ $heroCard->getKey() ? 'Edit' : 'New' }} Hero Card</x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-6 space-y-4">
                <div class="col-span-full">
                    @if($heroCard->getFirstMedia('heroCard'))
                    <x-input.group for="hero_card_banner" label="Hero Card Banner" error="" editable editLabel="Remove" editAction="editImage('heroCard')">
                        <img src="{{ $heroCard->getFirstMedia('heroCard')?->getURL() ?? null }}" />
                    </x-input.group>
                    @else
                    <x-input.group for="upload_banner" label="Upload a Banner" error="bannerUpload">
                        <x-input.file-upload label="Add a Banner" for="banner_upload">
                            <input id="banner_upload" name="banner_upload" type="file" wire:model.live="bannerUpload" class="sr-only">
                        </x-input.file-upload>
                    </x-input.group>
                    @endif
                </div>
                <div class="col-span-full">
                    @if($heroCard->getFirstMedia('logo'))
                    <x-input.group for="hero_card_logo" label="Hero Card Logo" error="" editable editLabel="Remove" editAction="editImage('logo')">
                        <img src="{{ $heroCard->getFirstMedia('logo')?->getURL() ?? null }}" />
                    </x-input.group>
                    @else
                    <x-input.group for="upload_logo" label="Upload a Logo" error="logoUpload">
                        <x-input.file-upload label="Upload a file" for="logo_upload">
                            <input id="logo_upload" name="logo_upload" type="file" wire:model="logoUpload" class="sr-only">
                        </x-input.file-upload>
                    </x-input.group>
                    @endif
                </div>

                <div class="col-span-4">
                    <x-input.group for="card_order" label="Order" error="heroCard.order">
                        <x-input.number wire:model="heroCard.order" id="card_order" />
                    </x-input.group>
                </div>

                <div class="col-span-full">
                    <x-input.group for="" label="Assign to a Projcet" error="">
                        <x-input.select wire:model.defer="heroCard.project_id" id="project_id" placeholder="">
                            <option value=""></option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
        <x-toolbar>
            <x-toolbar.flex />
            <x-button type="button" class="bg-gray-700 hover:bg-gray-600" wire:click="closeModal()">Close</x-button>
            <x-button type="submit" class="bg-blue-800 hover:bg-blue-600">Save</x-button>
        </x-toolbar>
        </x-slot>
    </x-modal.livewire-ui>
    </form>