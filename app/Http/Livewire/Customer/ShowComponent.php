<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowComponent extends Component
{
    use WithFileUploads,  WithPagination;
    public $set;
    public $photo, $buisinessname, $tradename;
    public $id_Customer;
    public $search;
    public $modal;
    public $user;
    public $photoPath;

    public function render()
{
    return view('livewire.customer.show-component', [
        'Customer' =>Customer::paginate(1),
    ]);
}

    public function OpenModal()
    {
        $this->modal = true;
    }

    public function Offmodal()
    {
        $this->modal = false;
    }

    public function cleanfields()
    {
        $this->photo = '';
        $this->buisinessname = '';
        $this->tradename = '';
    }
    public function edit($id)
    {
        $Customer = Customer::findOrFail($id);
        $this->id_Customer = $id;
        $this->photo = $Customer->photo;
        $this->buisinessname = $Customer->buisinessname;
        $this->tradename = $Customer->tradename;
        $this->OpenModal();
    }

    public function delete($id)
    {
        $this->user=Customer::find($id);
        $this->user->delete();
    }

    public function save()
    {

        if ($this->photo) {

            $photoPath = $this->photo->storeAs("public/Imagenes", uniqid() . '-' . $this->photo->getClientOriginalName());
            Customer::updateOrCreate(['id' => $this->id_Customer], [
                'photo' => $photoPath,
                'buisinessname' => $this->buisinessname,
                'tradename' => $this->tradename,
            ]);
        }
        $this->cleanfields();
        $this->Offmodal();
    }
}
