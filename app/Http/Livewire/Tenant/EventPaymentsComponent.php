<?php

namespace App\Http\Livewire\Tenant;

use App\Http\Livewire\Util\CrudComponent;
use App\Models\Event;
use App\Models\EventPayment;

class EventPaymentsComponent extends CrudComponent
{
    public $events = ['beforeSave', 'specialValidator'];

    public function beforeSave($data)
    {
        $data['user_id'] = auth()->user()->id;
        return $data;
    }
    public function mount()
    {
        $this->setup(EventPayment::class, [
            'mainKey' => 'id',
            'types' => [
                'event_id' => [
                    'type' => 'select',
                    'options' => Event::all()->map(function ($event) {
                        return [
                            'value' => $event->id,
                            'label' => $event->name,
                        ];
                    }),
                ],
                'notes' => [
                    'type' => 'text',
                ],
                'amount' => [
                    'type' => 'number',
                ],
            ],
        ]);
    }

    public function getTotal($event)
    {
        $total = $event['price'] ?? 0;
        foreach ($event['products'] as $data) {
            $total += $this->products->find($data['product_id'])->price * $data['quantity'];
        }
        return $total;
    }

    public function getRemaining($event)
    {
        $remaining = $this->getTotal($event);
        foreach ($event['payments'] as $payment) {
            $remaining -= $payment['amount'];
        }
        return $remaining;
    }

    public function specialValidator($payment)
    {
        $event = Event::find($payment['event_id']);
        $remaining = $this->getRemaining($event);

        return [
            'amount' => 'numeric|max:' . $remaining,
        ];
    }
}
