<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ToasterComponent extends Component
{
    use LivewireAlert;

    protected $listeners = ['toast'];
    public function toast($type, $message)
    {
        $this->alert($type, $message, [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.toaster-component');
    }
}
