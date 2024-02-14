<?php

namespace App\Http\Livewire\Tenant\Spaces;

use App\Http\Livewire\Tenant\Spaces\ScheduleComponent;
use App\Http\Livewire\Util\CrudComponent;

use App\Events\SpaceEvent;
use App\Models\Space;
use App\Models\SpacePhoto;

class ShowComponent extends CrudComponent
{
    public function mount()
    {
        $this->setup(Space::class,  [
            "mainKey" => "name",
            "types" => [
                "name" => ["type" => "text"],
                "photos" => [
                    "type" => "file",
                    "max" => 5,
                    "multiple" => true,
                    "accept" => ["image/jpeg", "image/png"],
                    "foreign" => [
                        "model" => SpacePhoto::class,
                        "key" => "space_id",
                        "name" => "url",
                    ],
                ],
                "description" => ["type" => "textarea",  "rows" => 4],
                "address" => ["type" => "text"],
                "city" => ["type" => "text"],
                "state" => ["type" => "text"],
                "country" => ["type" => "text"],
                "schedule" => [
                    "type" => "array",
                    "component" => ScheduleComponent::class,
                    "hidden" => true
                ],
                "color" => ["type" => "color"],
                "notes" => ["type" => "textarea", "rules" => "nullable"],
            ],
            "foreigns" => ["events"],
        ]);
    }
}
