<div class="relative">
    <div class="overflow-hidden relative">
        <div class="flex">
            @foreach($heroCards as $key => $heroCard)
                <div class="w-full {{ $activeIndex === $key ? 'block' : 'hidden' }}">
                    <div class="relative isolate bg-no-repeat bg-cover bg-center bg-transparent" style="background-image: url({{ $heroCard->getFirstMedia('heroCard')?->getURL() ?? null }})">
                        <div class="absolute w-full h-full bg-gradient-to-l from-transparent to-black -z-50"></div>
                        <div class="mx-auto px-6 lg:flex lg:items-center lg:gap-x-10 lg:px-8 relative">
                            <div class="mx-auto max-w-2xl lg:mx-0 lg:flex-auto">
                                <img src="{{ $heroCard->getFirstMedia('logo')?->getURL() ?? null }}" />
                                <p class="mt-6 text-lg leading-8 text-gray-200">
                                    {{ $heroCard->description }}
                                </p>
                                <div class="mt-10 mb-4 flex items-center gap-x-6">
                                    <x-fas-chevron-up class="-rotate-90 w-14 h-14 text-gray-400 absolute top-1/2 left-0 transform -translate-y-1/2 px-4 py-2 hover:text-gray-500 focus:text-gray-600 focus:outline-none opacity-50" wire:click="prev"/>
                                    <x-fas-chevron-up class="rotate-90 h-14 w-14 text-gray-400 absolute top-1/2 right-0 transform -translate-y-1/2 px-4 py-2 hover:text-gray-500 focus:text-gray-600 focus:outline-none opacity-50" wire:click="next"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- <script>
    function nextSlide() {
        Livewire.dispatch('next');
    }

    setInterval(nextSlide, 4000);
</script> --}}
