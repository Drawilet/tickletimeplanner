<?php

namespace App\Http\Livewire;

use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Validator;

class HomeComponent extends Component
{
    public $locale;

    public $data = [
        "name" => "",
        "email" => "",
        "message" => ""
    ];

    public $sent = false;

    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    public function render()
    {

        return view('livewire.home-component')->layout("layouts.guest");
    }

    public function submit()
    {
        Validator::make($this->data, [
            "name" => "required|max:255",
            "email" => "required|email",
            "message" => "required|max:500"
        ])->validate();

        Mail::to($this->data["email"])->send(new ContactEmail($this->data));

        $this->reset("data");

        $this->sent = true;
    }
}
