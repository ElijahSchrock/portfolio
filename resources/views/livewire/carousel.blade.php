<div class="relative">
    <div class="overflow-hidden relative">
        <div class="flex">
            @if(count($heroCards) > 0)
                @foreach($heroCards as $key => $heroCard)
                    <div class="w-full {{ $activeIndex === $key ? 'block' : 'hidden' }}">
                        <div class="relative isolate bg-no-repeat bg-cover bg-center bg-transparent" style="background-image: url({{ $heroCard->getFirstMedia('heroCard')?->getURL() ?? null }})">
                            <div class="absolute w-full h-full bg-gradient-to-l from-transparent to-black -z-50"></div>
                            <div class="absolute bottom-0 w-full h-1/4 bg-gradient-to-b from-transparent via-transparent to-[#151514] to-100% -z-50"></div>
                            <div class="mx-auto px-6 lg:flex lg:items-center lg:gap-x-10 lg:px-8 relative">
                                <div class="mx-auto max-w-2xl lg:mx-0 lg:flex-auto">
                                    <img src="{{ $heroCard->getFirstMedia('logo')?->getURL() ?? null }}" />
                                    <div class="ml-4 flex items-center gap-x-6">
                                        <a href="#" class="rounded-md bg-gray-100 px-3.5 py-2.5 text-lg font-semibold shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-300 flex justify-center items-center">
                                            <x-fas-play class="h-4 w-4 mr-2" />
                                            Play
                                        </a>
                                    </div>
                                    <div class="mt-10 mb-4 flex items-center gap-x-6">
                                        <x-fas-chevron-up class="-rotate-90 w-14 h-14 text-gray-400 absolute top-1/2 left-0 transform -translate-y-1/2 px-4 py-2 hover:text-gray-500 focus:text-gray-600 focus:outline-none opacity-50" wire:click="prev"/>
                                        <x-fas-chevron-up class="rotate-90 h-14 w-14 text-gray-400 absolute top-1/2 right-0 transform -translate-y-1/2 px-4 py-2 hover:text-gray-500 focus:text-gray-600 focus:outline-none opacity-50" wire:click="next"/>
                                    </div>
                                </div>
                            </div>
                            <h2 class="text-xl font-bold tracking-tight text-white ml-8">New Releases</h2>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="w-full">
                    <div class="relative isolate bg-no-repeat bg-cover bg-center bg-transparent" style="background-image: url(/coming_soon.png)">
                        <div class="absolute w-full h-full bg-gradient-to-l from-transparent to-black -z-50"></div>
                        <div class="absolute w-full h-full bg-gradient-to-b from-transparent via-transparent to-black -z-50"></div>
                        <div class="mx-auto px-6 lg:flex lg:items-center lg:gap-x-10 lg:px-8 relative">
                            <div class="mx-auto max-w-2xl lg:mx-0 lg:flex-auto">
                                <img src="/coming_soon_logo.png" />
                                <div class="ml-4 flex items-center gap-x-6">
                                    <a href="#" class="rounded-md bg-gray-100 px-3.5 py-2.5 text-lg font-semibold shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-300 flex justify-center items-center">
                                        <x-fas-play class="h-4 w-4 mr-2" />
                                        Play
                                    </a>
                                </div>
                                <div class="mt-10 mb-4 flex items-center gap-x-6">
                                    <x-fas-chevron-up class="-rotate-90 w-14 h-14 text-gray-400 absolute top-1/2 left-0 transform -translate-y-1/2 px-4 py-2 hover:text-gray-500 focus:text-gray-600 focus:outline-none opacity-50"/>
                                    <x-fas-chevron-up class="rotate-90 h-14 w-14 text-gray-400 absolute top-1/2 right-0 transform -translate-y-1/2 px-4 py-2 hover:text-gray-500 focus:text-gray-600 focus:outline-none opacity-50"/>
                                </div>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold tracking-tight text-white ml-8">New Releases</h2>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- <script>
    function nextSlide() {
        Livewire.dispatch('next');
    }

    setInterval(nextSlide, 4000);
</script> --}}
