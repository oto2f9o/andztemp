<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class General extends Component {

    use WithFileUploads;

    /**
     * Components State
     */
    public $state = [
        'name' => '',
        'pages' => [],
        'homepage' => 0,
        'app_header' => '',
        'colors' => [
            'primary' => '#000000',
            'secondary' => '#000000',
            'tertiary' => '#000000'
        ],
        'cookie' => [],
        'custom_logo' => '',
        'custom_favicon' => '',
        'language' => 'en',
        'enable_create_from_url' => false,
        'disable_mailbox_slug' => false,
        'external_link_masker' => '',
        'custom_external_link_masker' => '',
        'enable_ad_block_detector' => false,
        'font_family' => [
            'head' => 'Poppins',
            'body' => 'Poppins',
        ],
    ];

    public $logo, $favicon;

    public function mount() {
        $pages = Page::where('parent_id', null)->get();
        foreach ($pages as $page) {
            $this->state['pages'][$page->id] = $page->title;
        }
        foreach ($this->state as $key => $value) {
            if (!in_array($key, ['pages'])) {
                $this->state[$key] = config('app.settings.' . $key);
            }
        }
        $logo = Setting::pick('logo');
        if ($logo) {
            $this->state['custom_logo'] = Storage::url($logo);
        } else if (Storage::exists('public/images/custom-logo.png')) {
            $this->state['custom_logo'] = Storage::url('public/images/custom-logo.png');
        }
        $favicon = Setting::pick('favicon');
        if ($favicon) {
            $this->state['custom_favicon'] = Storage::url($favicon);
        } else if (Storage::exists('public/images/custom-favicon.png')) {
            $this->state['custom_favicon'] = Storage::url('public/images/custom-favicon.png');
        }
    }

    public function update() {
        $this->validate(
            [
                'state.name' => 'required',
                'state.logo' => 'image|max:1024',
                'state.favicon' => 'image|max:1024',
                'state.font_family.head' => 'required',
                'state.font_family.body' => 'required',
            ],
            [
                'state.name.required' => 'App Name is Required',
                'state.logo.image' => 'Invalid Logo file',
                'state.logo.max' => 'Max Size is 1MB',
                'state.favicon.image' => 'Invalid Logo file',
                'state.favicon.max' => 'Max Size is 1MB',
                'state.font_family.head' => 'Heading Font Family is Required',
                'state.font_family.body' => 'Body Font Family is Required',
            ]
        );
        if ($this->logo) {
            $logo = $this->logo->storeAs('public/images', $this->logo->getClientOriginalName());
            Setting::put('logo', $logo);
        }
        if ($this->favicon) {
            $favicon = $this->favicon->storeAs('public/images', $this->favicon->getClientOriginalName());
            Setting::put('favicon', $favicon);
        }
        if ($this->state['homepage'] != 0) {
            $this->state['disable_mailbox_slug'] = false;
        }
        if ($this->state['external_link_masker'] == 'custom') {
            $this->state['external_link_masker'] = $this->state['custom_external_link_masker'];
        }
        $settings = Setting::whereIn('key', ['name', 'homepage', 'app_header', 'colors', 'cookie', 'language', 'enable_create_from_url', 'disable_mailbox_slug', 'external_link_masker', 'enable_ad_block_detector', 'font_family'])->get();
        foreach ($settings as $setting) {
            $setting->value = serialize($this->state[$setting->key]);
            $setting->save();
        }
        $this->emit('saved');
    }

    public function render() {
        if (!in_array($this->state['external_link_masker'], ['', 'https://relink.cc', 'http://hidereferrer.net', 'custom'])) {
            $this->state['custom_external_link_masker'] = $this->state['external_link_masker'];
            $this->state['external_link_masker'] = 'custom';
        }
        return view('backend.settings.general');
    }
}
