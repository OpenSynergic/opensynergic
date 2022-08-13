@php
    $state = $getRecord();
@endphp

<div class="w-full px-2 filament-tables-text-column pt-3">
    <span class="block">{{ $state->description }}</span>
    <div class="inline-flex text-gray-700 text-xs">
        Version: <span class="ml-1 hover:text-gray-500">{{ $state->version }}</span>
        <span class="mx-2">|</span>
        By: <a href="#" class="ml-1 text-sky-600 hover:text-sky-500">{{ $state->author }}</a>
        <span class="mx-2">|</span>
        <a href="#" class="text-sky-600 hover:text-sky-500" x-data="{}" 
            x-on:click="$dispatch('open-modal', { id: 'view-detail-{{ $state->pluginName }}' })">View details</a>
    </div>
</div>

<x-filament::modal 
    id="view-detail-{{ $state->pluginName }}">
    <x-slot name="header">
        <x-filament::modal.heading>
            Detail {{ $state->name }}
        </x-filament::modal.heading>
    </x-slot>

    {{ $state->detail }}
</x-filament::modal>