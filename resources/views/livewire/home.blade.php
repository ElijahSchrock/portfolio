    <div>
        <div class="bg-[#151514] min-h-screen" x-data="{ open: false }" x-cloak>
            {{-- <header> --}}
                <nav class="bg-[#151514] mx-auto flex max-w-10xl items-center justify-between lg:justify-start p-6 lg:px-8 sticky top-0 z-10" aria-label="Global">
                    <a href="#" class="-m-1.5 p-1.5 mr-5">
                        <span class="sr-only">Elijah Schrock</span>
                        <img class="h-6 w-auto" src="/the_logo.png" alt="">
                    </a>
                    <div class="flex lg:hidden">
                        <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" x-on:click="open = !open">
                            <span class="sr-only">Open main menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                    <div class="hidden lg:flex lg:gap-x-12">
                        <p wire:click="downloadResume" class="text-sm font-semibold leading-6 text-slate-300 hover:cursor-pointer">Resume</p>
                        <p class="text-sm font-semibold leading-6 text-slate-300 hover:cursor-pointer" wire:click="$dispatch('openModal', { component: 'about-me-modal' })">About</p>
                    </div>
                </nav>
                <!-- Mobile menu, show/hide based on menu open state. -->
                <div class="lg:hidden" role="dialog" aria-modal="true" x-show="open" x-cloak>
                    <!-- Background backdrop, show/hide based on slide-over state. -->
                    <div class="fixed inset-0 z-50"></div>
                    <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-[#0c0c0b] px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10" x-on:click.away="open = false">
                        <div class="flex items-center justify-between">
                            <a href="#" class="-m-1.5 p-1.5 mr-5">
                                <span class="sr-only">Elijah Schrock</span>
                                <img class="h-6 w-auto" src="/the_logo.png" alt="">
                            </a>
                            <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" x-on:click="open = !open">
                                <span class="sr-only">Close menu</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-6 flow-root" >
                            <div class="-my-6 divide-y divide-gray-500/10">
                                <div class="space-y-2 py-6" x-on:click="open = !open">
                                    <p wire:click="downloadResume" class="text-sm font-semibold leading-6 text-slate-300 hover:cursor-pointer">Resume</p>
                                    <p class="text-sm font-semibold leading-6 text-slate-300 hover:cursor-pointer" wire:click="$dispatch('openModal', { component: 'about-me-modal' })">About</p>
                                </div>
                                <div class="py-6">
                                    {{-- <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-300 hover:bg-[#151514]">Log in</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </header> --}}

            <main>
                <div class="bg-[#151514]">
                    <livewire:carousel :heroCards="$heroCards"/>
                    
                    {{-- cards --}}
                    <div class="mx-auto max-w-8xl px-4 pb-16 sm:px-6 sm:pb-16 lg:max-w-10xl lg:px-8">
                        {{-- <h2 class="text-xl font-bold tracking-tight text-white">New Releases</h2> --}}

                        <!-- Project Cards -->
                        <div class="flex flex-col m-auto p-auto">
                            <div class="flex overflow-x-scroll pb-10 scrollbar scrollbar-thumb-slate-600 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                                <div class="flex flex-nowrap">
                                    @if(count($projects) > 0)
                                        @foreach($projects as $project)
                                            <div class="inline-block {{ $loop->last ? '' : 'pr-8'}}">
                                                <div class="w-48 h-60 sm:w-64 sm:h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out hover:cursor-pointer" wire:click="$dispatch('openModal', { component: 'project-modal', arguments: { project: {{ $project->id ?? null}} }})" wire:key="{{ $project->id }}">
                                                    <img src="{{ $project->getFirstMedia('images')?->getURL() ?? null }}"/>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="inline-block">
                                            <div class="w-48 h-60 sm:w-64 sm:h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                                <img src="coming_soon_card.JPEG"/>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <h2 class="text-xl font-bold tracking-tight text-white mt-2">Trending Now</h2>
                        <!-- Contact Stuff -->
                        <div class="flex flex-col m-auto p-auto">
                            <div class="flex overflow-x-scroll pb-7 scrollbar scrollbar-thumb-slate-600 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                                <div class="flex flex-nowrap">
                                    <div class="inline-block pr-5 sm:pr-10">
                                        <a href="mailTo:elijahschrock.dev@gmail.com"> 
                                            <div class="w-48 sm:w-80 overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                                <img src="/email.png"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="inline-block pr-5 sm:pr-10">
                                        <a href="tel:702-752-2318">
                                            <div class="w-48 sm:w-80 overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                                <img src="/phone.png"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="inline-block pr-5 sm:pr-10">
                                        <a href="https://www.linkedin.com/in/elijah-schrock/" target="_blank">
                                            <div class="w-48 sm:w-80 overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                                <img src="/linkedin.png"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="inline-block pr-5 sm:pr-10">
                                        <a href="https://github.com/elijahschrockAGT" target="_blank">
                                            <div class="w-48 sm:w-80 overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                                <img src="/github.png"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="inline-block">
                                        <a href="https://www.google.com/maps/place/Las+Vegas,+NV/@36.1248871,-115.339809,11z/data=!3m1!4b1!4m6!3m5!1s0x80beb782a4f57dd1:0x3accd5e6d5b379a3!8m2!3d36.171563!4d-115.1391009!16zL20vMGN2M3c?entry=ttu" target="_blank">
                                            <div class="w-48 sm:w-80 overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                                <img src="/location.png"/>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>

    </div>
