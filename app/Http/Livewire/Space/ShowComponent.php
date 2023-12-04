<?php

namespace App\Http\Livewire\Space;

use App\Events\SpaceEvent;
use App\Http\Livewire\Util\CrudComponent;
use App\Models\Space;
use App\Models\SpacePhoto;

class ShowComponent extends CrudComponent
{
    public function mount()
    {
        $this->setup(Space::class, SpaceEvent::class, [
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
                    "component" => "space.schedule-component",
                    "hidden" => true
                ],
                "color" => ["type" => "color"],
            ],
        ]);
    }
}
