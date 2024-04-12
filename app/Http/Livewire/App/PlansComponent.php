<?php

namespace App\Http\Livewire\App;

use App\Http\Livewire\Util\CrudComponent;
use App\Models\Plan;

class PlansComponent extends CrudComponent
{
    public function mount()
    {
        $this->setup(Plan::class, [
            'mainKey' => 'name',
            "scope" => "app",
            'types' => [
                'name' => ['type' => 'text'],
                'price' => ['type' => 'number'],
                'duration' => ['type' => 'number'],
                'duration_unit' => [
                    'type' => 'select',
                    'options' => [
                        ['value' => 'day', 'label' => __('plan-lang.day')],
                        ['value' => 'week', 'label' => __('plan-lang.week')],
                        ['value' => 'month', 'label' => __('plan-lang.month')],
                        ['value' => 'year', 'label' => __('plan-lang.year')],
                    ]
                ],
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
            'foreigns' => ['tenants'],
        ]);
    }
}
