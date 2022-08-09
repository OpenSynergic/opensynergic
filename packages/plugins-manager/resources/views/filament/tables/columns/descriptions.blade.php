@php
    $state = $getState() ? json_decode($getState()) : false;
@endphp

<div class="w-full px-2 filament-tables-text-column">
    <span class="block">{{ $state->simple_description }}</span>
    <div class="inline-flex text-gray-700 text-xs">
        Version: <span class="mx-2 hover:text-gray-500">{{ $state->version }}</span>
        |
        By: <span class="mx-2 hover:text-gray-500">{{ $state->author }}</span>
        |
        Detail: {modal}
    </div>
</div>