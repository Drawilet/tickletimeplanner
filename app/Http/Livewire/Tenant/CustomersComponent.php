<?php

namespace App\Http\Livewire\Tenant;

use App\Http\Livewire\Util\CrudComponent;
use App\Models\Customer;

class CustomersComponent extends CrudComponent
{
    public function mount()
    {
        $this->setup(Customer::class, [
            'mainKey' => 'firstname',
            'types' => [
                'firstname' => ['type' => 'text'],
                'lastname' => ['type' => 'text'],
                'email' => ['type' => 'email'],
                'phone' => ['type' => 'tel'],
                'address' => ['type' => 'textarea', 'rows' => 4],
                'notes' => ['type' => 'textarea', 'rules' => 'nullable'],
            ],
            'mobileStyles' => "
                .firstname,
                .lastname {
                     width: 50%;
                     font-size: 1.2rem;
                }

                .firstname, .email {
                    justify-content: flex-end;
                    padding-right: 5px;
                }

                .email,
                .phone {
                     width: 50%;

                }



            ",
            'foreigns' => ['events'],
        ]);
    }
}
