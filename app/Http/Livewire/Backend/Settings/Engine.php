<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use App\Models\Setting;

class Engine extends Component {

    /**
     * Components State
     */
    public $state = [
        'engine' => 'imap',
        'delivery' => [
            'key' => '',
        ]
    ];

    public function updatedState($value) {
        $this->emit('engineUpdated', $value);
    }

    public function mount() {
        $this->state['engine'] = config('app.settings.engine');
        $this->state['delivery'] = config('app.settings.delivery');
        $this->state['delivery']['key'] = base64_encode(config('app.url') . '|' . $this->state['delivery']['key']);
    }

    public function update() {
        $setting = Setting::where('key', 'engine')->first();
        $setting->value = serialize($this->state[$setting->key]);
        $setting->save();
        $this->emit('saved');
    }

    public function render() {
        return view('backend.settings.engine');
    }
}
