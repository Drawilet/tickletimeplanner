<?php

namespace App\Http\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class Show extends Component
{
    public $initialData = [
        "name" => "",
        "schedule" => [],
        "opening" => "",
        "closing" => "",
    ];
    public $data;

    public $days = [
        "sunday",
        "monday",
        "tuesday",
        "wednesday",
        "thursday",
        "friday",
        "saturday",
    ];
    public function mount()
    {
        $this->data = Setting::first()?->toArray() ?? $this->initialData;
    }

    public function render()
    {
        return view('livewire.settings.show');
    }

    public function toggleDay($day)
    {
        if (in_array($day, $this->data['schedule'])) {
            $this->data['schedule'] = array_diff($this->data['schedule'], [$day]);
        } else {
            array_push($this->data['schedule'], $day);
        }
    }

    public function save()
    {
        $this->validate([
            'data.name' => 'required',
            'data.schedule' => 'required',
            'data.opening' => 'required',
            'data.closing' => ['required', 'after:data.opening'],
        ]);

        Setting::updateOrCreate(
            ['id' => 1],
            $this->data
        );
        $this->emit('saved');
    }
}
