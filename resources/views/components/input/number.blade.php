<div x-data="{ 
    value : @entangle($attributes->wire('model')),
    addValue : function(inc) {
        if(this.value.length == 0) {
            this.value = 0;
            return;
        }
        this.value = parseInt(this.value) + inc; $dispatch('input', this.value);
    }    
}" class="flex rounded-md shadow-sm">

    <input
        type="text"
        x-model="value"
        x-mask="9999999999999999999"
        x-on:keydown.arrow-down.prevent="addValue(-1)"
        x-on:keydown.arrow-up.prevent="addValue(1);"
        x-on:keydown.arrow-up.shift.prevent="addValue(99)"
        x-on:keydown.arrow-down.shift.prevent="addValue(-99)"
        x-on:keydown.arrow-up.shift.cmd.prevent="addValue(900)"
        x-on:keydown.arrow-down.shift.cmd.prevent="addValue(-900)"
        {{ $attributes->whereDoesntStartWith('wire:click')->whereDoesntStartWith('wire:model') }}
        class="bg-slate-800 text-gray-400 flex-1 input-focus-ring input-focus-border block w-full sm:text-sm border-gray-700 shadow-sm rounded-l-md"
    />

    <div class="inline-flex items-center px-2 rounded-r-md border border-l-0 border-gray-700 bg-gray-700 text-gray-400 sm:text-sm outline-none flex-col">
        <button tabindex="-1" type="button" x-on:click="addValue(1)" class="flex-1 items-center outline-none focus:outline-none">
            <x-fas-caret-up class="w-4 h-4 outline-none" />
        </button>
        <button tabindex="-1" type="button" x-on:click="addValue(-1)" class="flex-1 items-center outline-none focus:outline-none">
            <x-fas-caret-down class="w-4 h-4 outline-none" />
        </button>
    </div>


</div>