<?php

namespace App\Http\Livewire\Util;

use Livewire\Component;

class CrudComponent extends Component
{
    public $primaryKey;
    public $keys;
    public $Model, $ItemEvent;
    public  $Name, $name;

    public $initialData, $data;

    public $modals = [
        "save" => false,
        "delete" => false,
        "error" => false
    ];

    public $items, $count = 0;

    public function setup($Model, $ItemEvent, $keys, $initialData, $primaryKey)
    {
        $this->Model = $Model;
        $this->ItemEvent = $ItemEvent;
        $this->keys = $keys;
        $this->initialData = $initialData;
        $this->initialData["id"] = "";
        $this->data = $initialData;

        $this->primaryKey = $primaryKey;

        $this->Name = class_basename($this->Model);
        $this->name = strtolower($this->Name);
    }

    public function render()
    {
        return view('livewire.util.crud-component');
    }

    public function socketHandler($e)
    {
        $action = $e["action"];
        $data = $e["data"];

        switch ($action) {
            case 'create':
                $item = $this->Model::make($data);
                $item->id = $data["id"];

                $this->items->push($item);
                break;

            case "update":
                $item = $this->items->first(function ($item) use ($data) {
                    return $item->id === $data["id"];
                });
                if ($item) {
                    $item->fill($data);
                }
                break;

            case "delete":
                $this->items = $this->items->filter(function ($item) use ($data) {
                    return $item->id != $data["id"];
                });
                break;
            default:
                # code...
                break;
        }

        $this->emit("notify", [
            "type" => "info",
            "message" =>  $data[$this->primaryKey] . " $this->name " . $action . "d"
        ]);
    }

    /*<──  ───────    UTILS   ───────  ──>*/
    public function clean()
    {
        $this->data = $this->initialData;
    }

    public function Modal($modal, $value, $id = null)
    {
        if ($value == true) {
            $this->clean();
            switch ($modal) {
                case 'save':
                    if ($id) {
                        $item = $this->Model::find($id);
                        $this->data = $item->toArray();
                    }
                    break;
                case 'delete':
                    $item = $this->items->find($id);
                    $this->data = $item->toArray();

                    break;

                default:
                    # code...
                    break;
            }
        }
        $this->modals[$modal] = $value;
    }

    public function save()
    {
        $item = $this->Model::updateOrCreate(["id" => $this->data["id"]], $this->data);

        event(new $this->ItemEvent($this->data["id"] ? "update" : "create", $item));

        $this->Modal("save", false);
    }

    public function delete()
    {
        $this->Modal("delete", false);
        $item = $this->Model::find($this->data["id"]);

        /*   $this->count = $item->products->count();
        if ($this->count > 0) {
            return $this->Modal("error", true);
        } */

        $item->delete();

        event(new $this->ItemEvent("delete", $this->data));
    }
}
