<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Socket\WithCrudSockets;
use Livewire\Component;

class FilterComponent extends Component
{
    use WithCrudSockets;

    public $filters = [
        "spaces" => [],
    ];

    public $spaces;
    public function mount()
    {
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);
        $this->filters["spaces"] = $this->spaces->pluck("id")->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.filter-component');
    }

    public function toggleSpace($spaceId)
    {
        if ($spaceId == "all") {
            if (count($this->spaces) == count($this->filters['spaces']))
                $this->filters["spaces"] = [];
            else
                $this->filters["spaces"] = $this->spaces->pluck("id")->toArray();

            $this->emit("update-filters", $this->filters);
            return;
        }

        if (!in_array($spaceId, $this->filters["spaces"])) {
            $this->filters["spaces"][] = $spaceId;
        } else {
            $this->filters["spaces"] = array_diff($this->filters["spaces"], [$spaceId]);
        }

        $this->emit("update-filters", $this->filters);
    }
}
