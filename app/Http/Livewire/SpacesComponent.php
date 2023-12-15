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
        "location" => null,
    ];

    public function mount()
    {
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);
    }

    public function render()
    {
        $this->filteredSpaces = $this->spaces->filter(function ($space) {
            //Filter country
            if ($this->filters["location"]) {
                if (
                    strtolower($space->country) != strtolower($this->filters["location"]["countryCode"])
                    && strtolower($space->country) != strtolower($this->filters["location"]["countryName"])
                ) {
                    return false;
                }

                //Filter city
                if (
                    strtolower($space->city) != strtolower($this->filters["location"]["city"])
                    && strtolower($space->city) !=  strtolower($this->filters["location"]["locality"])
                ) {
                    return false;
                }
            }

            //Filter name
            if ($this->filters["name"] != null) {
                if (strpos(strtolower($space->name), strtolower($this->filters["name"])) === false) {
                    return false;
                }
            }

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
