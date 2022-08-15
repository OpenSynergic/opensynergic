<x-filament::page>    
    <x-backend::tabs>
        <x-slot:buttons>
            <x-backend::tabs.button>General</x-backend::tabs.button>

            @if ($generalFormData['enable'])
                <x-backend::tabs.button>Gateway</x-backend::tabs.button>
            @endif
        </x-slot:buttons>
        
        <x-backend::tabs.content>
            <div
                class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <form wire:submit.prevent="submitGeneralForm">
                    {{ $this->generalForm }}

                    <div
                        class="filament-page-actions mt-6 flex flex-wrap items-center gap-4 justify-start filament-form-actions">
                        <x-filament-support::button type="submit" class="">
                            Submit
                        </x-filament-support::button>
                    </div>
                </form>
            </div>
        </x-backend::tabs.content>
        <x-backend::tabs.content>

            {{ $this->table }}
            
        </x-backend::tabs.content>
    </x-backend::tabs>
</x-filament::page>