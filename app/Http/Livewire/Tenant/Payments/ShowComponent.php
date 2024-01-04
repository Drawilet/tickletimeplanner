<?php

namespace App\Http\Livewire\Tenant\Payments;

use App\Http\Livewire\Util\CrudComponent;
use App\Models\Event;
use App\Models\Payment;

class ShowComponent extends CrudComponent
{
    public $events = ["beforeSave"];

    public function beforeSave($data)
    {
        $data["user_id"] = auth()->user()->id;
        return $data;
    }

    public function mount()
    {
        $this->setup(Payment::class, Payment::class, [
            "mainKey" => "id",
            "types" => [
                "event_id" => [
                    "type" => "select",
                    "options" => Event::all()->map(function ($event) {
                        return [
                            "value" => $event->id,
                            "label" => $event->name,
                        ];
                    }),
                ],
                "notes" => [
                    "type" => "text",
                ],
                "amount" => [
                    "type" => "number",
                ],
            ],
            "foreigns" => ["events"],
        ]);
    }
}
