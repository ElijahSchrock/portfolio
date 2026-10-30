<div>
    <div class="w-full">
        <div class="relative isolate bg-no-repeat bg-position-[center_right_-18rem] md:bg-center bg-cover" style="background-image: url({{ $project->heroCard?->getFirstMedia('heroCard')?->getURL() }})">
            <div class="absolute w-full h-full bg-linear-to-b from-transparent via-transparent to-black -z-50"></div>
            <div class="mx-auto px-6 lg:flex lg:items-center lg:gap-x-10 lg:px-8 relative">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:flex-auto">
                    <div class="w-80 h-96">
                        @if(filled($project->site))
                            <a href="{{ $project->site }}" target="_blank" rel="noopener noreferrer"
                               aria-label="Visit {{ $project->name }} live site (opens in a new tab)"
                               class="absolute bottom-8 left-6 lg:left-8 inline-flex items-center gap-3 rounded-md bg-white px-5 py-3 text-sm font-semibold text-gray-900 shadow-lg transition hover:bg-gray-200 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M8 5.5a1 1 0 0 1 1.5-.866l10 6a1 1 0 0 1 0 1.732l-10 6A1 1 0 0 1 8 17.5v-12Z" />
                                </svg>
                                Visit live site
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M7 7h10v10" />
                                </svg>
                            </a>
                        @endif
                        <button wire:click="closeModal()" type="button" class="absolute top-2 right-4 p-2 text-gray-300 hover:text-gray-500 transition ease-in-out duration-150 text-3xl outline-hidden bg-[#191819] rounded-full">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="ltr-4z3qvp e1svuwfo1" data-name="X" aria-labelledby="preview-modal-70266676" data-uia="previewModal-closebtn" role="button" aria-label="close" tabindex="0">
                                <title id="preview-modal-70266676">close</title>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5858 12L2.29291 3.70706L3.70712 2.29285L12 10.5857L20.2929 2.29285L21.7071 3.70706L13.4142 12L21.7071 20.2928L20.2929 21.7071L12 13.4142L3.70712 21.7071L2.29291 20.2928L10.5858 12Z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 pb-7 bg-linear-to-t from-[#191819] via-[#191819] to-black">
            <div class="ml-4">
                @foreach($techStacks as $tech)
                    <x-pill label="{{ $tech }}" color="red" />
                @endforeach
            </div>
            <div class="mt-3 grid grid-cols-1 items-start gap-6 lg:grid-cols-7 lg:gap-x-4">
                <div class="min-w-0 lg:col-span-5">
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-2 text-slate-300">
                        <h2 class="text-lg font-bold text-green-600">{{ rand(95, 100) }}% Match</h2>
                        @if(filled($project->year_created))
                            <h2 class="text-lg font-bold text-gray-400">{{ $project->year_created }}</h2>
                        @endif
                        <div class="flex shrink-0 items-center gap-2 text-gray-400">
                            <x-fas-code class="h-5 w-5" />
                            <x-fas-code-branch class="h-4 w-4" />
                            <x-fas-terminal class="h-4 w-4" />
                        </div>
                    </div>
                    <h2 class="mt-3 text-lg font-bold text-slate-300">{{ $project->name }}</h2>
                    <div class="mt-1 text-gray-400">
                        {{ $project->description }}
                    </div>
                </div>
                <div class="min-w-0 space-y-4 text-sm lg:col-span-2">
                    <div>
                        <span class="text-gray-500">Stack:</span> <span class="text-gray-200">{{ $project->tech_stack }}</span>
                    </div>
                    @if(filled($project->other_tech))
                        <div>
                            <span class="text-gray-500">Other Technologies:</span> <span class="text-gray-200">{{ $project->other_tech }}</span>
                        </div>
                    @endif
                    @if(filled($project->repository_url))
                        <div>
                            <h3 class="mb-2 text-sm font-medium text-gray-500">Behind the Build</h3>
                            <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer"
                               aria-label="View {{ $project->name }} source (opens in a new tab)"
                               class="inline-flex items-center gap-2 text-sm font-medium text-gray-400 transition hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                                <x-fab-github class="h-5 w-5" aria-hidden="true" />
                                View source
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M7 7h10v10" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
