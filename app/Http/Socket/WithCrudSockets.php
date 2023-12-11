<?php

namespace App\Http\Socket;

use App\Events\EventEvent;
use App\Events\CustomerEvent;
use App\Events\ProductEvent;
use App\Events\SpaceEvent;
use App\Events\UserEvent;
use App\Models\Event;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Space;
use App\Models\User;

trait WithCrudSockets
{
    private $registry = [
        "customer" => [
            "Event" => CustomerEvent::class,
            "Model" => Customer::class,
        ],
        "product" => [
            "Event" => ProductEvent::class,
            "Model" => Product::class,
        ],
        "space" => [
            "Event" => SpaceEvent::class,
            "Model" => Space::class,
        ],
        "event" => [
            "Event" => EventEvent::class,
            "Model" => Event::class,
        ],
        "user"=> [
            "Event" => UserEvent::class,
            "Model" => User::class,
        ]
    ];


    public function handleSocket($key, $e)
    {
        $type = $this->registry[$key];
        $socket = $this->socketListeners[$key];

        $Model = $type["Model"];

        $var = $socket["useItemsKey"] ? "items" : $key . "s";

        $action = $e["action"];
        $data = $e["data"];

        switch ($action) {
            case 'create':
                $item = $Model::make($data);
                $item->id = $data["id"];

                $this->$var->push($item);
                break;

            case "update":
                $item = $this->$var->first(function ($item) use ($data) {
                    return $item->id === $data["id"];
                });
                if ($item) {
                    $item->fill($data);
                }
                break;

            case "delete":
                $this->$var = $this->$var->filter(function ($item) use ($data) {
                    return $item->id != $data["id"];
                });
                break;
            default:
                # code...
                break;
        }
        /*      $this->emit("notify", [
            "type" => "info",
            "message" =>  $data[$this->mainKey] . " $this->name " . $action . "d"
        ]); */

        if (isset($socket["afterUpdate"])) $this->{$socket["afterUpdate"]}();
    }

    public $socketListeners = [];
    public function addSocketListener($key, $options)
    {
        if (!isset($options["useItemsKey"])) $options["useItemsKey"] = true;
        $key = strtolower($key);

        $data = $this->registry[$key];

        $this->socketListeners[$key] = [
            "event" => class_basename($data["Event"]),
            "useItemsKey" => $options["useItemsKey"],
            "afterUpdate" => $options["afterUpdate"] ?? null,
        ];

        if (isset($options["get"]) && $options["get"] === true) {
            $var = $options["useItemsKey"] ? "items" : $key . "s";
            $this->$var = $data["Model"]::all();
        }
    }
}
