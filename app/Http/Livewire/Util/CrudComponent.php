<?php

namespace App\Http\Livewire\Util;

use App\Http\Traits\WithCrudActions;
use App\Http\Traits\WithValidations;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrudComponent extends Component
{
    protected $listeners =  ["update-data" => "handleData"];

    use WithFileUploads, WithCrudActions, WithValidations;

    public $mainKey, $keys;
    public $Model, $ItemEvent;
    public  $Name, $name;

    public $initialData, $data, $initialFiles, $files;
    public $types;

    public $crudRules = [];
    public $defaultValues = [
        "text" => "",
        "textarea" => "",
        "file" => ""
    ];

    public $modals = [
        "save" => false,
        "delete" => false,
        "error" => false
    ];

    public $items, $showingItems, $count = 0;

    public $initialFilter = [
        "search" => ""
    ], $filter;

    public $events = [];

    public $foreigns = [];

    public function setup($Model, array $params)
    {
        $this->Model = $Model;

        $this->addCrud($Model, ["get" => false]);
        $this->items = $this->Model::where("tenant_id", auth()->user()->tenant_id)->get();

        $this->initialData = ["id"  => ""];
        $this->initialFiles = [];
        foreach ($params["types"] as $key => $type) {
            if ($type["type"] != "file")
                $this->crudRules[$key] = $type["rules"] ?? "required|" . $this->validations[$type["type"]];



            if (isset($type["hidden"]) && $type["hidden"] == true) continue;
            $this->keys[] = $key;
            if ($type["type"] == "file") $this->initialFiles[$key] = [];
            $this->initialData[$key] = $type["default"] ?? $this->defaultValues[$type["type"]] ?? "";
        }
        $this->data = $this->initialData;
        $this->files = $this->initialFiles;

        $this->types = $params["types"];

        $this->mainKey = $params["mainKey"] ?? $params['keys'][0];

        $this->Name = class_basename($this->Model);
        $this->name = strtolower($this->Name);

        $this->filter = $this->initialFilter;

        $this->foreigns = $params["foreigns"] ?? [];
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

    public function handleData($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /*<──  ───────    UTILS   ───────  ──>*/
    public function clean()
    {
        $this->data = $this->initialData;
        $this->files = $this->initialFiles;
    }

    public function Modal($modal, $value, $id = null)
    {
        if ($value == true) {
            $this->clean();
            switch ($modal) {
                case 'save':
                    if ($id) {
                        $item = $this->Model::find($id);
                        if (in_array("beforeOpenSaveModal", $this->events)) $this->data = $this->beforeOpenSaveModal($item);
                        else $this->data = $item->toArray();
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

            $this->emit("update-data", $this->data);
        }
        $this->modals[$modal] = $value;
    }

    public function save()
    {
        Validator::make($this->data, $this->crudRules)->validate();

        if (in_array("beforeSave", $this->events)) $this->data = $this->beforeSave($this->data);
        $item = $this->Model::updateOrCreate(["id" => $this->data["id"]], $this->data);

        $name = $this->name;
        $id = $item->id;
        foreach ($this->types as $key => $type) {
            if ($type["type"] != "file") continue;

            if (!isset($this->files[$key])) continue;
            if (gettype($this->files[$key]) == "string") continue;

            $files = gettype($this->files[$key]) == "array" ? $this->files[$key] : [$this->files[$key]];
            if ($this->data["id"] && count($files) != 0) {
                $oldFiles = $item->$key;
                if (gettype($oldFiles) == "string") {
                } else if (isset($this->types[$key]["foreign"])) {
                    $foreignFile = $this->types[$key]["foreign"];
                    $model = $foreignFile["model"];
                    $foreign_key = $foreignFile["key"];
                    $foreign_name = $foreignFile["name"];

                    foreach ($oldFiles as $oldFile) {
                        $_file = $oldFile->$foreign_name;
                        $_file = str_replace("/storage", "public", $_file);

                        Storage::delete($_file);

                        $model::where($foreign_key, $id)->where($foreign_name, $oldFile[$foreign_name])->delete();
                    }
                }
            }

            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs("/public/$name/$id/$key", $fileName);

                $path = "/storage/$name/$id/$key/$fileName";

                if (isset($this->types[$key]["foreign"])) {
                    $foreignFile = $this->types[$key]["foreign"];
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
        if (in_array("afterSave", $this->events)) $this->afterSave($item, $this->data);

        $this->handleCrudActions(
            $this->name,
            [
                "action" => $this->data["id"] ? "update" : "create",
                "data" => $item->toArray()
            ]
        );

        $this->Modal("save", false);
        $this->emit("toast", "success", $this->Name . " " . __("toast-lang.savedsuccessfully"));
    }
    public function delete()
    {
        $this->Modal("delete", false);
        $item = $this->Model::find($this->data["id"]);

        foreach ($this->foreigns as $foreign) {
            $items = $item->$foreign;
            if (count($items) != 0) {
                $this->modals["error"] = true;
                $this->emit("toast", "error", __('toast-lang.cannotdelete') . " " . __(strtolower($item->{$this->mainKey})) . " " . __('toast-lang.because') . " " . __('toast-lang.has') . " " . __("toast-lang." . $foreign));
                return;
            }
        }

        $item->delete();

        $this->handleCrudActions(
            $this->name,
            [
                "action" => "delete",
                "data" => $this->data
            ]
        );

        $this->emit("toast", "success", $this->Name . " " . __('toast-lang.deletedsuccessfully'));
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
