<?php

namespace App\Http\Livewire\Settings;

use App\Models\AppSettings;
use Livewire\Component;

class AppSettingsComponent extends Component
{
    public $data = [
        'monthly_price' => null,
    ];


    public function mount()
    {
        $this->data = AppSettings::first()->toArray();
    }


    public function render()
    {
        return view('livewire.settings.app-settings-component');
    }


    public function save()
    {
        AppSettings::first()->update($this->data);
        $this->emit('saved');
    }
}
