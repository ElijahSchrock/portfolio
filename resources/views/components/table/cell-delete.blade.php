@props([
    'action' => ''
])

<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 hover:cursor-pointer" wire:click="{{ $action }}">
    <span class="text-red-600 hover:text-red-500">Delete</span>
</td>