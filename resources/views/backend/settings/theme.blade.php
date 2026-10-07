<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Theme Options') }}
    </x-slot>

    <x-slot name="description">
        {{ __('You will see here theme specific options.') }}
    </x-slot>

    <x-slot name="form">
        @if (config('app.settings.theme') == 'groot' || config('app.settings.theme') == 'drax')
        <div class="col-span-6">
            <x-jet-label for="mailbox_page" value="{{ __('Mailbox Page') }}" />
            <div class="relative">
                <select class="form-input rounded-md shadow-sm mt-1 block w-full cursor-pointer" wire:model.defer="state.theme_options.mailbox_page">
                    <option value="0">{{ __('None') }}</option>
                    @foreach ($state['pages'] as $id => $page)
                        <option value="{{ $id }}">{{ $page }}</option>
                    @endforeach
                </select>
            </div>
            <x-jet-input-error for="state.theme_options.mailbox_page" class="mt-2" />
            <small class="block mt-1">{{ __('Selected Page Content will be shown on App Page') }}</small>
        </div>
        @endif
        @if (config('app.settings.theme') == 'drax')
        <div class="col-span-6">
            <label class="block text-sm text-gray-700 font-bold mb-2">{{ __('Special Button') }}</label>
            <div class="flex">
                <div>
                    <x-jet-label for="drax_btn_text" value="{{ __('Text') }}" />
                    <x-jet-input type="text" class="mt-1 block w-full" wire:model.defer="state.theme_options.button.text" placeholder="eg. thehp" />
                </div>
                <div class="ml-2 flex-1">
                    <x-jet-label for="drax_btn_link" value="{{ __('Link') }}" />
                    <x-jet-input type="text" class="mt-1 block w-full" wire:model.defer="state.theme_options.button.link" placeholder="eg. https://thehp.in" />
                </div>
            </div>
        </div>
        @endif
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
