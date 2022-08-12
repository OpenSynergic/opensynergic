<x-filament::page :class="\Illuminate\Support\Arr::toCssClasses([
    'filament-pages-list-records-page',
    'filament-pages-' . str_replace('/', '-', $this->getSlug()),
])">
    <x-backend::tabs>
       <x-slot:buttons>
           <x-backend::tabs.button wire:click="$set('tab', 'all')">
                All
            </x-backend::tabs.button>
            <x-backend::tabs.button wire:click="$set('tab', 'activate')">
               <div class="flex flex-1">
                   <span class="inline-flex mr-1">Activate</span>
                   <span 
                    class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-gray-500 bg-gray-300">
                        {{ $countActivate }}
                    </span>
               </div>
           </x-backend::tabs.button>
           <x-backend::tabs.button wire:click="$set('tab', 'deactivate')">
               <div class="flex flex-1">
                   <span class="inline-flex mr-1">Deactivate</span>
                   <span 
                    class="inline-flex items-center justify-center ml-auto rtl:ml-0 rtl:mr-auto min-h-4 px-2 py-0.5 text-xs font-medium tracking-tight rounded-xl whitespace-normal text-gray-500 bg-gray-300">
                        {{ $countDeactivate }}
                    </span>
               </div>
           </x-backend::tabs.button>
           <x-backend::tabs.button wire:click="$set('tab', 'drop-in')">
               Drop-in
           </x-backend::tabs.button>
       </x-slot:buttons>
    </x-backend::tabs>

    {{ $this->table }}
</x-filament::page>