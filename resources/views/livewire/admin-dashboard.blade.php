<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
    <div class="mx-auto max-w-3xl p-6">
        <div class="">
            <form wire:submit.prevent="save">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-white">Release A New Project</h2>
        
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="username" class="block text-sm font-medium leading-6 text-white">Project Name</label>
                                <div class="mt-2">
                                        <x-input.group for="name" label="" error="name">
                                            <x-input.text wire:model="name" id="name" placeholder="Enter Project Name" />
                                        </x-input.group>
                                </div>
                            </div>
        
                            <div class="col-span-full">
                                <x-input.group for="description" label="Description" error="description">
                                    <x-input.textarea wire:model="description" id="description" rows="3" placeholder="Enter Project Description"/>
                                </x-input.group>
                            </div>
        
                            <div class="col-span-full">
                            <x-input.group for="upload" label="File Upload" error="fileUpload">
                                @unless ($fileUpload)
                                <x-input.file-upload label="Upload a file" for="file-upload">
                                    <input id="file-upload" name="file-upload" type="file" wire:model="fileUpload" class="sr-only">
                                </x-input.file-upload>
                                @else
                                <div class="space-y-4" wire:loading.class="opacity-25" wire:loading.attr="disabled">
                                    <div class="text-sm font-bold text-slate-300 space-y-2 p-3 rounded-md bg-slate-800 border border-slate-700 shadow-sm">
                                        {{-- @foreach($uploads as $file) --}}
                                        <div class="flex justify-between">
                                            <div>{{ $fileUpload->getClientOriginalName() }}</div>
                                            <button class="flex items-center space-x-2 text-gray-400 hover:text-slate-500 text-sm leading-5 font-medium focus:outline-none focus:underline transition duration-150 ease-in-out" wire:click="removeFile">
                                            <x-dynamic-component component="fas-trash-can" class="h-4 w-4" />
                                            Remove File
                                        </button>
                                        </div>
                                        {{-- @endforeach --}}
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
  </div>
  