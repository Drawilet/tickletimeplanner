<?php

namespace App\Http\Livewire\Util;

use Livewire\Component;
use Livewire\WithFileUploads;

class CrudComponent extends Component
{
    use WithFileUploads;

    public $mainKey, $keys;
    public $Model, $ItemEvent;
    public  $Name, $name;

    public $initialData, $data, $specialInputs, $foreignFiles;

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
        $this->keys = $params['keys'];
        $this->initialData = $params['initialData'];
        $this->initialData["id"] = "";
        $this->data = $params['initialData'];
        $this->specialInputs = $params["specialInputs"] ?? [];
        $this->foreignFiles = $params["foreignFiles"] ?? [];

        $this->mainKey = $params["mainKey"] ?? $params['keys'][0];

        $this->Name = class_basename($this->Model);
        $this->name = strtolower($this->Name);

        $this->filter = $this->initialFilter;
    }

    public function render()
    {
        $this->showingItems = $this->items->filter(function ($item) {
            $search = $this->filter["search"];
            if ($search == "") return true;

            if (isset($item[$this->mainKey])) {
                $value = $item[$this->mainKey];
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
            "message" =>  $data[$this->mainKey] . " $this->name " . $action . "d"
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
        foreach ($this->specialInputs as $key => $data) {
            if ($data["type"] != "file") continue;

            if (!isset($this->data[$key])) continue;
            if (gettype($this->data[$key]) == "string") continue;

            $files = gettype($this->data[$key]) == "array" ? $this->data[$key] : [$this->data[$key]];
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs("/public/$name/$id/$key", $fileName);

                $path = "/storage/$name/$id/$key/$fileName";

                if (isset($this->foreignFiles[$key])) {
                    $foreignFile = $this->foreignFiles[$key];
                    $model = $foreignFile["model"];
                    $foreign_key = $foreignFile["key"];
                    $foreign_name = $foreignFile["name"];

                    $model::create([
                        $foreign_key => $id,
                        $foreign_name => $path
                    ]);
                } else {
                    $item->$key = $path;
                }
            }
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

    public function parseValue($value)
    {
        switch (gettype($value)) {
            case 'array':
                return implode(", ", $value);

            default:
                return $value;
        }
    }
}
