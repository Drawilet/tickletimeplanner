<?php

namespace App\Http\Livewire\Tenant\Spaces;

use Livewire\Component;

class ScheduleComponent extends Component
{
    protected $listeners = ['update-data' => 'handleData'];

    public $data = [
        'schedule' => [],
    ];

    public $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    public $selectedDay;

    public function render()
    {
        return view('livewire.tenant.spaces.schedule-component');
    }

    public function handleData($data)
    {
        if (isset($data['schedule'])) {
            $this->data['schedule'] = $data['schedule'];
        } else {
            $this->data['schedule'] = [];
        }
    }

    public function handleScheduleChange()
    {
        $this->emit('update-data', $this->data);
    }

    public function toggleDay($day)
    {
        if (!isset($this->data['schedule'][$day])) {
            $this->data['schedule'][$day] = [
                'opening' => '',
                'closing' => '',
            ];
        }

        $this->selectedDay = $day;
    }

    function removeDay()
    {
        unset($this->data['schedule'][$this->selectedDay]);
        $this->emit('update-data', $this->data);
    }
    function copyDay()
    {
        foreach ($this->days as $day) {
            $this->data['schedule'][$day] = $this->data['schedule'][$this->selectedDay];
        }

        $this->emit('update-data', $this->data);
    }
}
