<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Mail Setup') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Mail Setup is required to send out any communications for the contact form.') }}
    </x-slot>
    
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="mail" value="{{ __('Mail Type') }}" />
            <div class="relative">
                <select id="mail" class="form-input border-gray-300 rounded-md shadow-sm mt-1 block w-full cursor-pointer" wire:model="state.mail.type">
                    <option selected disabled value="empty">{{ __('Select a Type') }}</option>
                    <option value="smtp">{{ __('SMTP') }}</option>
                    <option value="log">{{ __('Log') }}</option>
                </select>
            </div>
            <x-jet-input-error for="mail" class="mt-2" />
            @if($state['mail']['type'] == 'log')
            <small class="text-gray-500 block mt-2">{{ __('Your emails will be stored at /storage/logs/laravel.log file') }}</small>
            @endif
        </div>
        @if($state['mail']['type'] == 'smtp')
        <div class="col-span-6 sm:col-span-4 grid grid-cols-1 gap-6">
            <div>
                <x-jet-label for="smtp_host" value="{{ __('Host') }}" />
                <x-jet-input id="smtp_host" type="text" class="mt-1 block w-full" wire:model.defer="state.mail.smtp.host" />
                <x-jet-input-error for="state.mail.smtp.host" class="mt-1 mb-2" />
            </div>
            <div>
                <x-jet-label for="smtp_port" value="{{ __('Port') }}" />
                <x-jet-input id="smtp_port" type="text" class="mt-1 block w-full" wire:model.defer="state.mail.smtp.port" />
                <x-jet-input-error for="state.mail.smtp.port" class="mt-1 mb-2" />
            </div>
            <div>
                <x-jet-label for="smtp_username" value="{{ __('Username') }}" />
                <x-jet-input id="smtp_username" type="text" class="mt-1 block w-full" wire:model.defer="state.mail.smtp.username" />
                <x-jet-input-error for="state.mail.smtp.username" class="mt-1 mb-2" />
            </div>
            <div x-data="{ show_password: false }">
                <x-jet-label for="smtp_password" value="{{ __('Password') }}" />
                <div class="relative">
                    <x-jet-input id="smtp_password" x-bind:type="show_password ? 'text' : 'password'" class="mt-1 block w-full" placeholder="{{ __('Enter the Password') }}" wire:model.defer="state.mail.smtp.password" autocomplete="new-password"/>
                    <div x-on:click="show_password = !show_password" x-text="show_password ? 'HIDE' : 'SHOW'" class="cursor-pointer absolute inset-y-0 right-0 flex items-center px-5 text-xs"></div>
                </div>
                <x-jet-input-error for="state.mail.smtp.password" class="mt-2" />
            </div>
            <div>
                <x-jet-label for="smtp_encryption" value="{{ __('Encryption') }}" />
                <div class="relative">
                    <select id="smtp_encryption" class="form-input border-gray-300 rounded-md shadow-sm mt-1 block w-full cursor-pointer" wire:model.defer="state.mail.smtp.encryption">
                        <option selected disabled value="empty">{{ __('Select a Encryption Type') }}</option>
                        <option value="tls">{{ __('TLS') }}</option>
                        <option value="ssl">{{ __('SSL') }}</option>
                        <option value="none">{{ __('None') }}</option>
                    </select>
                </div>
                <x-jet-input-error for="state.mail.smtp.encryption" class="mt-2" />
            </div>
            <div>
                <x-jet-label for="from_address" value="{{ __('From Address') }}" />
                <x-jet-input id="from_address" type="text" class="mt-1 block w-full" wire:model.defer="state.mail.from.address" />
                <x-jet-input-error for="state.mail.from.address" class="mt-1 mb-2" />
            </div>
            <div>
                <x-jet-label for="from_name" value="{{ __('From Name') }}" />
                <x-jet-input id="from_name" type="text" class="mt-1 block w-full" wire:model.defer="state.mail.from.name" />
                <x-jet-input-error for="state.mail.from.name" class="mt-1 mb-2" />
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