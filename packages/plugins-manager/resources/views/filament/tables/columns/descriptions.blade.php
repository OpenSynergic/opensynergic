@php
    $state = $getState() ? json_decode($getState()) : false;
@endphp

<div class="w-full px-2 filament-tables-text-column">
    <span class="block">{{ $state->simple_description }}</span>
    <div class="inline-flex text-gray-700 text-xs">
        Version: <span class="ml-1 hover:text-gray-500">{{ $state->version }}</span>
        <span class="mx-2">|</span>
        By: <a href="#" class="ml-1 text-sky-600 hover:text-sky-500">{{ $state->author }}</a>
        <span class="mx-2">|</span>
        <a href="#" class="text-sky-600 hover:text-sky-500">View details</a>
    </div>
</div>