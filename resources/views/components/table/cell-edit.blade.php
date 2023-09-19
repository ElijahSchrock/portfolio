@props([
    'action' => ''
])

<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 hover:cursor-pointer" wire:click="{{ $action }}">
    <span class="text-indigo-400 hover:text-indigo-300">Edit</span>
</td>