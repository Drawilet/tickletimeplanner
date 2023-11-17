<?php

namespace App\Http\Livewire\Event;

use Livewire\Component;

class ShowComponent extends Component
{
    public $initialFilter = [
        "display_mode" => "table",
        "search" => ""
    ];
    public $filter;

    public function mount()
    {
        $this->filter = $this->initialFilter;
    }

    public function render()
    {
        return view('livewire.event.show-component');
    }

    public function changeDisplayMode($mode)
    {
        $this->filter['display_mode'] = $mode;
    }
}
