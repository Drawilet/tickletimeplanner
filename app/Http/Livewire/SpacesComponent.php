<?php

namespace App\Http\Livewire;

use App\Http\Socket\WithCrudSockets;
use App\Models\Space;
use Livewire\Component;

class SpacesComponent extends Component
{
    use WithCrudSockets;

    protected $listeners = [
        "socket" => "handleSocket",
        "setFilter" => "setFilter",
    ];

    public $spaces, $filteredSpaces;

    public $currentSpace;
    public $modals = [
        "contact" => false,
    ];
    public $filters = [
        "name" => null,
        "city" => null,
        "country" => null,
    ];

    public function mount()
    {
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);
    }

    public function render()
    {
        $this->filteredSpaces = $this->spaces->filter(function ($space) {
            if ($this->filters["country"] != null && strpos(strtolower($space->country), strtolower($this->filters["country"])) === false)
                return false;

            if ($this->filters["city"]  != null && strpos(strtolower($space->city), strtolower($this->filters["city"])) === false)
                return false;

            if ($this->filters["name"] != null && strpos(strtolower($space->name), strtolower($this->filters["name"])) === false)
                return false;

            return true;
        });

        return view('livewire.spaces-component')->layout("layouts.guest");
    }

    public function Modal($modal, $value, $data = null)
    {
        if ($data) {
            $this->currentSpace = $this->spaces->find($data);
        }

        $this->modals[$modal] = $value;
    }

    public function setFilter($key, $value)
    {
        $this->filters[$key] = $value;
    }
}
