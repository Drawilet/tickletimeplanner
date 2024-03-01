<?php

namespace App\Http\Livewire\Tenant;

use App\Http\Livewire\Tenant\Spaces\ScheduleComponent;
use App\Http\Livewire\Util\CrudComponent;

use App\Models\Space;
use App\Models\SpacePhoto;

class ShowSpaces extends CrudComponent
{
    public function mount()
    {
        $this->setup(Space::class, [
            'mainKey' => 'name',
            'types' => [
                'name' => ['type' => 'text'],
                'photos' => [
                    'type' => 'file',
                    'max' => 5,
                    'multiple' => true,
                    'accept' => ['image/jpeg', 'image/png'],
                    'foreign' => [
                        'model' => SpacePhoto::class,
                        'key' => 'space_id',
                        'name' => 'url',
                    ],
                ],
                'description' => ['type' => 'textarea', 'rows' => 4],
                'address' => ['type' => 'text'],
                'city' => ['type' => 'text'],
                'state' => ['type' => 'text'],
                'country' => ['type' => 'text'],
                'schedule' => [
                    'type' => 'array',
                    'component' => ScheduleComponent::class,
                    'hidden' => true,
                ],
                'color' => ['type' => 'color'],
                'notes' => ['type' => 'textarea', 'rules' => 'nullable'],
            ],
            'mobileStyles' => "
                .name {
                    width: 100%;
                    justify-content: center;
                    font-size: 1.2rem;
                    margin-bottom: -8px;
                }

                .photos {
                    width: 100%;
                    justify-content: center;
                    margin-bottom: 10px;
                }

                .description {
                    width: 100%;
                    justify-content: center;
                    font-size: 1rem;
                }

                .address, .city, .state, .country {
                    width: 25%;
                    justify-content: center;
                    font-size: 1rem;
                }

                .color {
                    width: 100%;
                    justify-content: center;
                    font-size: 1rem;
                }

                .color span {
                    margin-top: 10px;
                    width: 100% !important;
                    border-radius: 5px !important;
                }

            ",
            'foreigns' => ['events'],
        ]);
    }
}
