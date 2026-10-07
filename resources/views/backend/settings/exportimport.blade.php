<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Export / Import') }}
    </x-slot>

    <x-slot name="description">
        {{ __('You can export all the TMail settings using this. You can use this to restore the site settings if you plan to re-create the site from scatrch.') }}
    </x-slot>
    
    <x-slot name="form">
        <div class="col-span-6">
            <x-jet-label value="{{ __('Export Settings') }}" />
            <button type="button" wire:click="export" class="mt-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">{{ __('Export') }}</button>
        </div>
        <div class="col-span-6">
            <x-jet-label value="{{ __('Import Settings') }}" />
            <small class="text-red-700 font-bold block mt-1">{{ __('Caution: This will override all the existing settings!') }}</small>
            <input class="block mt-2 text-xs" type="file" name="import" id="import">
            <button type="button" id="import-settings" class="mt-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">{{ __('Import') }}</button>
        </div>
        <x-jet-action-message class="mr-3" on="imported">
            {{ __('Imported.') }}
        </x-jet-action-message>
    </x-slot>
</x-jet-form-section>