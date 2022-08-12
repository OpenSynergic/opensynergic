@php
    $state = $getRecord();
@endphp

<div class="px-4 py-3 filament-tables-text-column">
    <span class="block font-bold">{{ $state->name }}</span>
    <div class="inline-flex text-gray-700 text-xs">
        Setting
        |
        Update
    </div>
</div>