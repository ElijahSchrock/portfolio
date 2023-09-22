<div>
    <div class="w-full">
        <div class="relative isolate bg-no-repeat bg-cover bg-center bg-transparent" style="background-image: url({{ $project->heroCard->getFirstMedia('heroCard')?->getURL() }})">
            <div class="absolute w-full h-full bg-gradient-to-b from-transparent via-transparent to-black -z-50"></div>
            <div class="mx-auto px-6 lg:flex lg:items-center lg:gap-x-10 lg:px-8 relative">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:flex-auto">
                    <div class="w-80 h-96">
                        <button wire:click="closeModal()" type="button" class="absolute top-2 right-4 p-2 text-gray-300 hover:text-gray-500 transition ease-in-out duration-150 text-3xl outline-none bg-[#191819] rounded-full">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="ltr-4z3qvp e1svuwfo1" data-name="X" aria-labelledby="preview-modal-70266676" data-uia="previewModal-closebtn" role="button" aria-label="close" tabindex="0">
                                <title id="preview-modal-70266676">close</title>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5858 12L2.29291 3.70706L3.70712 2.29285L12 10.5857L20.2929 2.29285L21.7071 3.70706L13.4142 12L21.7071 20.2928L20.2929 21.7071L12 13.4142L3.70712 21.7071L2.29291 20.2928L10.5858 12Z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 pb-7 bg-gradient-to-t from-[#191819] via-[#191819] to-black">
            <div class="grid grid-cols-7 space-x-4">
                <div class="col-span-full lg:col-span-4 ml-4">
                    @foreach($techStacks as $tech)
                        <x-pill label="{{ $tech }}" color="red" />
                    @endforeach
                </div>
                <div class="col-span-full lg:col-start-1 lg:col-span-3 text-slate-300 mt-3 flex space-x-2">
                    <h2 class="text-lg font-bold text-green-600">{{ rand(95, 100) }}% Match</h2>
                    <h2 class="text-lg font-bold text-gray-400">{{ $project->year_created }}</h2>
                    <div class="flex justify-between items-center text-gray-400">
                        <x-fas-code class="h-5 w-5 ml-2" />
                        <x-fas-code-branch class="h-4 w-4 ml-2" />
                        <x-fas-terminal class="h-4 w-4 ml-2" />

                    </div>
                </div>
                <div class="col-span-5 lg:col-start-6 lg:col-span-2 text-sm">
                    <span class="text-gray-500">Stack:</span> <span class="text-gray-200">{{ $project->tech_stack }}</span>
                </div>
                <div class="hidden lg:block lg:col-start-1 lg:col-span-3 text-slate-300 mt-3">
                    <h2 class="text-lg font-bold">{{ $project->name }}</h2>
                </div>
                <div class="col-span-full lg:col-start-6 lg:col-span-2 text-sm">
                    <span class="text-gray-500">Other Technologies:</span> <span class="text-gray-200">{{ $project->other_tech }}</span>
                </div>
                <div class="col-span-full lg:hidden text-slate-300 mt-3">
                    <h2 class="text-lg font-bold">{{ $project->name }}</h2>
                </div>
                <div class="col-span-full lg:col-span-5 text-gray-400">
                    {{ $project->description }}
                </div>
            </div>
        </div>
    </div>
</div>
