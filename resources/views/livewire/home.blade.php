    <div>
        <div class="bg-[#151514]" x-data="{ open: false }" x-cloak>
            {{-- <header> --}}
                <nav class="bg-[#151514] mx-auto flex max-w-10xl items-center justify-between lg:justify-start p-6 lg:px-8 sticky top-0 z-50" aria-label="Global">
                    <a href="#" class="-m-1.5 p-1.5 mr-5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
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
                        <a href="#" class="text-sm font-semibold leading-6 text-gray-900 dark:text-slate-300">Product</a>
                        <a href="#" class="text-sm font-semibold leading-6 text-gray-900 dark:text-slate-300">Features</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-slate-300">Register</a>

                        <a href="{{ route('login') }}"" class=" text-sm font-semibold leading-6 text-gray-900 dark:text-slate-300">Log in <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </nav>
                <!-- Mobile menu, show/hide based on menu open state. -->
                <div class="lg:hidden" role="dialog" aria-modal="true" x-show="open" x-cloak>
                    <!-- Background backdrop, show/hide based on slide-over state. -->
                    <div class="fixed inset-0 z-50"></div>
                    <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-[#0c0c0b] px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10" x-on:click.away="open = false">
                        <div class="flex items-center justify-between">
                            <a href="#" class="-m-1.5 p-1.5">
                                <span class="sr-only">Your Company</span>
                                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
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
                                <div class="space-y-2 py-6">
                                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-300 hover:bg-[#151514]">Product</a>
                                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-300 hover:bg-[#151514]">Features</a>
                                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-300 hover:bg-[#151514]">Marketplace</a>
                                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-300 hover:bg-[#151514]">Company</a>
                                </div>
                                <div class="py-6">
                                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-300 hover:bg-[#151514]">Log in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </header> --}}

            <main>
                <div class="bg-[#151514]">
                    <div class="relative isolate" style="background-image: url(https://cosmic-portfolio.sfo3.digitaloceanspaces.com/17/IMG_2772.JPEG)">
                        <div class="absolute w-full h-full bg-gradient-to-l from-transparent to-black -z-50"></div>
                        <div class="mx-auto px-6 lg:flex lg:items-center lg:gap-x-10 lg:px-8">
                            <div class="mx-auto max-w-2xl lg:mx-0 lg:flex-auto">
                                <h1 class="mt-10 max-w-lg text-4xl font-bold tracking-tight text-white sm:text-6xl">A better way to ship your projects</h1>
                                <p class="mt-6 text-lg leading-8 text-gray-200">Esse id magna consectetur fugiat non dolor in ad laboris magna laborum ea consequat. Nisi irure aliquip nisi adipisicing veniam voluptate id. In veniam incididunt ex veniam adipisicing sit.</p>
                                <div class="mt-10 mb-4 flex items-center gap-x-6">
                                    <a href="#" class="rounded-md bg-gray-100 px-3.5 py-2.5 text-lg font-semibold shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-300 flex justify-center items-center">
                                        <x-fas-play class="h-4 w-4 mr-2" />
                                        Play
                                    </a>
                                </div>
                            </div>
                            {{-- big ass phone --}}
                            <div class="mt-10 sm:mt-24 lg:mt-0 lg:flex-shrink-0 lg:flex-grow">
                                {{-- <svg viewBox="0 0 366 729" role="img" class="mx-auto w-[22.875rem] max-w-full drop-shadow-xl">
                                    <title>App screenshot</title>
                                    <defs>
                                        <clipPath id="2ade4387-9c63-4fc4-b754-10e687a0d332">
                                            <rect width="316" height="684" rx="36" />
                                        </clipPath>
                                    </defs>
                                    <path fill="#4B5563" d="M363.315 64.213C363.315 22.99 341.312 1 300.092 1H66.751C25.53 1 3.528 22.99 3.528 64.213v44.68l-.857.143A2 2 0 0 0 1 111.009v24.611a2 2 0 0 0 1.671 1.973l.95.158a2.26 2.26 0 0 1-.093.236v26.173c.212.1.398.296.541.643l-1.398.233A2 2 0 0 0 1 167.009v47.611a2 2 0 0 0 1.671 1.973l1.368.228c-.139.319-.314.533-.511.653v16.637c.221.104.414.313.56.689l-1.417.236A2 2 0 0 0 1 237.009v47.611a2 2 0 0 0 1.671 1.973l1.347.225c-.135.294-.302.493-.49.607v377.681c0 41.213 22 63.208 63.223 63.208h95.074c.947-.504 2.717-.843 4.745-.843l.141.001h.194l.086-.001 33.704.005c1.849.043 3.442.37 4.323.838h95.074c41.222 0 63.223-21.999 63.223-63.212v-394.63c-.259-.275-.48-.796-.63-1.47l-.011-.133 1.655-.276A2 2 0 0 0 366 266.62v-77.611a2 2 0 0 0-1.671-1.973l-1.712-.285c.148-.839.396-1.491.698-1.811V64.213Z" />
                                    <path fill="#343E4E" d="M16 59c0-23.748 19.252-43 43-43h246c23.748 0 43 19.252 43 43v615c0 23.196-18.804 42-42 42H58c-23.196 0-42-18.804-42-42V59Z" />
                                    <foreignObject width="316" height="684" transform="translate(24 24)" clip-path="url(#2ade4387-9c63-4fc4-b754-10e687a0d332)">
                                        <img src="https://tailwindui.com/img/component-images/mobile-app-screenshot.png" alt="" />
                                    </foreignObject>
                                </svg> --}}
                            </div>
                        </div>
                    </div>

                    {{-- cards --}}
                    <div class="mx-auto max-w-8xl px-4 py-16 sm:px-6 sm:py-16 lg:max-w-10xl lg:px-8">
                        <h2 class="text-2xl font-bold tracking-tight text-white">Customers also purchased</h2>

                        <!-- Project Cards -->
                        <div class="flex flex-col m-auto p-auto">
                            <div class="flex overflow-x-scroll pb-10 hide-scroll-bar">
                                <div class="flex flex-nowrap">
                                    @foreach($projects as $project)
                                        <div class="inline-block pr-7">
                                            <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                                <img src="{{ $project->getFirstMedia('images')?->getURL() ?? null }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold tracking-tight text-white">Contact me stuff</h2>
                        <!-- Contact Stuff -->
                        <div class="flex flex-col m-auto p-auto">
                            <div class="flex overflow-x-scroll pb-10 hide-scroll-bar">
                                <div class="flex flex-nowrap">
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                    <div class="inline-block pr-7">
                                        <div class="w-64 h-80 max-w-xs overflow-hidden rounded-lg shadow-md dark:bg-black hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>

    </div>
