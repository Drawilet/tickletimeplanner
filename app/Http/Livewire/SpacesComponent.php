<?php

namespace App\Http\Livewire;

use App\Http\Socket\WithCrudSockets;
use App\Models\Space;
use Livewire\Component;

class SpacesComponent extends Component
{
    use WithCrudSockets;

    public $spaces;

    public $currentSpace;
    public $modals = [
        "contact" => false,
    ];

    public function mount()
    {
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);
    }

    public function render()
    {
        return view('livewire.spaces-component')->layout("layouts.guest");
    }

    public function Modal($modal, $value, $data = null)
    {
        if ($data) {
            $this->currentSpace = $this->spaces->find($data);
        }

        $this->modals[$modal] = $value;
    }
}
