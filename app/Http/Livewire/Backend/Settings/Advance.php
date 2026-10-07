<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Advance extends Component {
    /**
     * Components State
     */
    public $state = [
        'lock' => [
            'enable' => false,
            'text' => '',
            'password' => ''
        ],
        'global' => [
            'css' => '',
            'js' => '',
            'header' => '',
            'footer' => ''
        ],
        'api_keys' => [],
        'ad_block_detector_filename' => '',
    ];

    public function mount() {
        $this->state['lock'] = config('app.settings.lock');
        $this->state['global'] = config('app.settings.global');
        $this->state['api_keys'] = config('app.settings.api_keys');
        $this->state['ad_block_detector_filename'] = config('app.settings.ad_block_detector_filename');
    }

    public function add() {
        array_push($this->state['api_keys'], $this->random());
    }

    public function remove($key) {
        unset($this->state['api_keys'][$key]);
    }

    private function random($length = 20) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($characters), 0, $length);
    }

    public function update() {
        $this->validate(
            [
                'state.api_keys.*' => 'required'
            ],
            [
                'state.api_keys.*.required' => 'API Key field is Required'
            ]
        );
        $settings = Setting::whereIn('key', ['lock', 'global', 'api_keys', 'ad_block_detector_filename'])->get();
        foreach ($settings as $setting) {
            $setting->value = serialize($this->state[$setting->key]);
            if ($setting->key == 'ad_block_detector_filename' && $this->state[$setting->key] !== config('app.settings.ad_block_detector_filename')) {
                $js = 'var e=document.createElement("div");e.id="Q8CvrZzY9fphm6gG",e.classList.add("hidden"),document.body.appendChild(e);';
                if (config('app.settings.ad_block_detector_filename')) {
                    Storage::disk('public')->delete('js/' . config('app.settings.ad_block_detector_filename'));
                }
                Storage::disk('public')->put('js/' . $this->state[$setting->key], $js);
                $setting->updated_at = Carbon::now()->addYear(5);
            }
            $setting->save();
        }
        $this->emit('saved');
    }

    public function render() {
        return view('backend.settings.advance');
    }
}
