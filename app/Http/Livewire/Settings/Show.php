<?php

namespace App\Http\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class Show extends Component
{
    public $social_nets = [
        [
            'url' => '',
            'icon' => 'components.icons.default-link'
        ],
    ];

    public function render()
    {
        return view('livewire.settings.show');
    }

    public function addSocialNet()
    {
        $this->social_nets[] = [
            'url' => '',
            'icon' => 'components/icons/default-link'
        ];
    }
}
