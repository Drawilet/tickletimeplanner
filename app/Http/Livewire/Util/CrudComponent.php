<?php

namespace App\Http\Livewire\Util;

use Livewire\Component;
use Livewire\WithFileUploads;

class CrudComponent extends Component
{
    use WithFileUploads;

    public $primaryKey, $keys;
    public $Model, $ItemEvent;
    public  $Name, $name;

    public $initialData, $data, $specialInputs, $files;

    protected $rules = [];

    public $modals = [
        "save" => false,
        "delete" => false,
        "error" => false
    ];

    public $items, $showingItems, $count = 0;

    public $initialFilter = [
        "search" => ""
    ], $filter;


    public function setup($Model, $ItemEvent, array $params)
    {
        $this->Model = $Model;
        $this->ItemEvent = $ItemEvent;
        $this->keys = $params['keys'] ;
        $this->initialData = $params['initialData'];
        $this->initialData["id"] = "";
        $this->data = $params['initialData'];
        $this->specialInputs = $params["specialInputs"] ?? [];
        $this->files = $params["files"] ?? [];

        $this->primaryKey = $params["primaryKey"] ?? $params['keys'][0];

        $this->Name = class_basename($this->Model);
        $this->name = strtolower($this->Name);

        $this->filter = $this->initialFilter;
    }

    public function render()
    {
        $this->showingItems = $this->items->filter(function ($item) {
            $search = $this->filter["search"];
            if ($search == "") return true;

            if (isset($item[$this->primaryKey])) {
                $value = $item[$this->primaryKey];
                if (stripos($value, $search) !== false) return true;
            }

            return false;
        });
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

        $name = $this->name;
        $id = $item->id;
        foreach ($this->files as $key => $data) {
            if (!isset($this->data[$key])) continue;
            if (gettype($this->data[$key]) == "string") continue;

            $file = $this->data[$key];

            $fileName = $file->getClientOriginalName();
            $file->storeAs("/public/$name/$id/$key", $fileName);
            $item->$key = "/storage/$name/$id/$key/$fileName";
        }
        $item->save();

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

    public function getInputType($key, $value)
    {
        if (isset($this->files[$key])) return "file";
        return gettype($value) == 'integer' ? 'number' : 'string';
    }
}
