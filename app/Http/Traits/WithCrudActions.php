<?php

namespace App\Http\Traits;

trait WithCrudActions
{
    public  $cruds = [];

    public function handleCrudActions($key, $e)
    {
        $crud = isset($this->cruds[$key]) ? $this->cruds[$key] : null;
        if (!$crud) return;

        $Model = $crud["Model"];

        $var = $crud["useItemsKey"] ? "items" : $key . "s";

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

        if (isset($crud["afterUpdate"])) $this->{$crud["afterUpdate"]}($action, $data);
    }
    public function addCrud($Model, $options = [])
    {
        if (!isset($options["useItemsKey"])) $options["useItemsKey"] = true;

        $key = strtolower((new \ReflectionClass($Model))->getShortName());

        $this->cruds[$key] = [
            "Model" => $Model,
            "useItemsKey" => $options["useItemsKey"],
            "afterUpdate" => $options["afterUpdate"] ?? null,
        ];

        if (isset($options["get"]) && $options["get"] === true) {
            $var = $options["useItemsKey"] ? "items" : $key . "s";
            $this->$var = $Model::all();
        }
    }
}
