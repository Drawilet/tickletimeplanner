<?php

namespace App\Http\Livewire\Tenant\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;

class ShowComponent extends Component
{
    use WithFileUploads;

    public $image_background;
    public $image_profile;
    public $name, $lastname, $bio, $location;
    public $social_nets = [
        [
            'url' => '',
            'icon' => 'components.icons.default-link'
        ],
    ];

    protected $rules = [
        'image_profile' => 'requiered|image|max:2048',
        'image_background' => 'required|image|2048'
    ];


    public function render()
    {
        return view('livewire.tenant.settings.show-component');
    }

    public function addSocialNet()
    {
        $this->social_nets[] = [
            'url' => '',
            'icon' => 'components/icons/default-link'
        ];
    }

    public function getValues(Request $request){
        $this->name=$request->get('name');
        $this->lastname=$request->get('lastname');
        $this->bio=$request->get('bio');
        $this->location=$request->get('location');
    }

    public function uploadImageProfile(Request $request){
        $request->validate([
            'image_profile' => 'required', //Validaciones de tamaño, tipo de archivo
        ]);
        if($this->image_profile){
            $this->image_profile->storeAs("profile-photos", "ejemplo.png");
        }

        ///$request->image->move(public_path('images'), $this->image_profile);
    }

    public function uploadImageBackground(Request $request){
        $request->validate([
            'image_background' => 'required', //Validaciones de tamaño, tipo de archivo
        ]);
        if($this->image_background){
            $this->image_background->storeAs("background-photos", "ejemplo.png");
        }
    }
}
