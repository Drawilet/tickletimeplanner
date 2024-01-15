<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SpAdmin;

class SpAdminComponent extends Component
{
  public $Users;

    public function render()
    {
        $this->Users = SpAdmin::all();
        return view('livewire.sp-admin-component');
    }
    public function delete($id)
    {
        $user = SpAdmin::find($id);
        $user->delete();
        session()->flash('message', 'User has been deleted successfully!');
    }
   


    
}
