@php
    $state = $getRecord();
@endphp

<div class="w-full px-2 filament-tables-text-column">
    <span class="block">{{ $state->description }}</span>
    <div class="inline-flex text-gray-700 text-xs">
        Version: <span class="ml-1 hover:text-gray-500">{{ $state->version }}</span>
        <span class="mx-2">|</span>
        By: <a href="#" class="ml-1 text-sky-600 hover:text-sky-500">{{ $state->author }}</a>
        <span class="mx-2">|</span>
        {{-- <a href="" class="text-sky-600 hover:text-sky-500">View details</a> --}}
        <a href="#" class="text-sky-600 hover:text-sky-500"
            x-data="{}" 
            x-on:click="$dispatch('open-modal', { id: '{{ $state->pluginName }}' })">Open modal</a>
    </div>
</div>

<x-filament::modal id="view-detail-{{ $state->pluginName }}">
    <x-slot name="heading">
        Import
    </x-slot>

    <form>
        sdsd
    </form>

    <x-slot name="actions">
        <x-filament::modal.actions full-width>
            ...
        </x-filament::modal.actions>
    </x-slot>
</x-filament::modal>