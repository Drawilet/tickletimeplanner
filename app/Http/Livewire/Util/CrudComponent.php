<?php

namespace App\Http\Livewire\Util;

use App\Http\Traits\WithCrudActions;
use App\Http\Traits\WithValidations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class CrudComponent extends Component
{
    protected $listeners = [
        'update-data' => 'handleData',
        'update-files' => 'handleFiles',
        'update-changelog' => 'handleChangelog',
    ];

    use WithFileUploads, WithCrudActions, WithValidations;

    public $mainKey, $keys;
    public $Model, $ItemEvent;
    public $Name, $name;

    public $initialData, $data, $initialFiles, $files;
    public $types;

    public $mobileStyles;

    public $crudRules;
    public $defaultValues = [
        'text' => '',
        'textarea' => '',
        'file' => '',
    ];

    public $modals = [
        'save' => false,
        'delete' => false,
        'error' => false,
    ];

    public $count = 0;
    public $items;

    public $initialFilter = [
        'search' => '',
    ],
    $filter;

    public $events = [];

    public $foreigns = [];

    public $skip_rows = 0;

    public $ITEMS_PER_PAGE = 10;
    public $CAN_LOAD_MORE = true;

    public $changelog = [];


    public $scope;


    public function setup($Model, array $params)
    {
        $this->Model = $Model;

        $this->addCrud($Model, ['get' => false]);

        $this->filter = $this->initialFilter;

        $this->items = new Collection();
        $this->loadMore();

        $this->initialData = ['id' => ''];
        $this->initialFiles = [];
        foreach ($params['types'] as $key => $type) {
            if (isset($type['hidden']) && $type['hidden'] == true) {
                continue;
            }

            if ($type['type'] != 'file') {
                $this->crudRules[$key] = $type['rules'] ?? 'required|' . $this->validations[$type['type']];
            }

            $this->keys[] = $key;
            if ($type['type'] == 'file') {
                $this->initialFiles[$key] = [];
            }
            $this->initialData[$key] = $type['default'] ?? ($this->defaultValues[$type['type']] ?? '');
        }
        $this->data = $this->initialData;
        $this->files = $this->initialFiles;

        $this->types = $params['types'];

        $this->mainKey = $params['mainKey'] ?? $params['keys'][0];

        $this->Name = class_basename($this->Model);
        $this->name = strtolower($this->Name);

        $this->foreigns = $params['foreigns'] ?? [];

        if (isset($params['mobileStyles'])) {
            $this->mobileStyles = $params['mobileStyles'];
        }

        $this->scope = $params['scope'] ?? "tenant";

    }

    public function render()
    {
        return view('livewire.util.crud-component');
    }

    public function loadMore()
    {
        $newItems = $this->Model
            ::when(in_array('additionalSql', $this->events), function ($query) {
                $this->additionalSql($query);
            })
            ->when($this->filter['search'] != '', function ($query) {
                return $query->where($this->mainKey, 'like', '%' . $this->filter['search'] . '%');
            })
            ->skip($this->skip_rows)
            ->take($this->ITEMS_PER_PAGE)
            ->get();

        $this->items = $this->items->merge($newItems);

        $this->skip_rows += $this->ITEMS_PER_PAGE;

        if ($newItems->count() < $this->ITEMS_PER_PAGE) {
            $this->CAN_LOAD_MORE = false;
        }
    }

    public function filterUpdated()
    {
        $this->skip_rows = 0;
        $this->items = new Collection();
        $this->CAN_LOAD_MORE = true;
        $this->loadMore();
    }

    public function handleData($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    public function handleFiles($data)
    {
        foreach ($data as $fileKey => $files) {
            $this->files[$fileKey] = [];
            foreach ($files as $key => $file) {
                if (isset($file['photo'])) {
                    $this->files[$fileKey][$key] = new TemporaryUploadedFile($file['photo'], config('filesystems.default'));
                }
            }
        }
    }

    public function handleChangelog($data)
    {
        $this->changelog[] = $data;
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
                        if (in_array('beforeOpenSaveModal', $this->events)) {
                            $this->data = $this->beforeOpenSaveModal($item);
                        } else {
                            $this->data = $item->toArray();
                        }
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

            $this->emit('update-data', $this->data);
        }
        $this->modals[$modal] = $value;
    }

    public function save()
    {
        if (in_array('specialValidator', $this->events)) {
            $specialRules = $this->specialValidator($this->data);
            $this->crudRules = array_merge($this->crudRules, $specialRules);
        }

        Validator::make($this->data, $this->crudRules)->validate();

        $isCreating = isset($this->data['id']) && $this->data['id'] == '';
        foreach ($this->types as $key => $type) {
            if (!isset($type['hidden']) || !$type['hidden']) {
                continue;
            }

            if ($type['type'] == 'file') {
                continue;
            }

            if ($isCreating) {
                Validator::make($this->data, [$key => 'required|' . $this->validations[$type['type']]])->validate();
            }
        }

        if (in_array('beforeSave', $this->events)) {
            $this->data = $this->beforeSave($this->data);
        }
        $item = $this->Model::updateOrCreate(['id' => $this->data['id']], $this->data);

        $name = $this->name;
        $id = $item->id;
        foreach ($this->types as $key => $type) {
            if ($type['type'] != 'file') {
                continue;
            }

            if (!isset($this->files[$key])) {
                continue;
            }
            if (gettype($this->files[$key]) == 'string') {
                continue;
            }

            $files = gettype($this->files[$key]) == 'array' ? $this->files[$key] : [$this->files[$key]];

            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs("/public/$name/$id/$key", $fileName);

                $path = "/storage/$name/$id/$key/$fileName";

                if (isset($this->types[$key]['foreign'])) {
                    $foreignFile = $this->types[$key]['foreign'];
                    $model = $foreignFile['model'];
                    $foreign_key = $foreignFile['key'];
                    $foreign_name = $foreignFile['name'];

                    $model::create([
                        $foreign_key => $id,
                        $foreign_name => $path,
                    ]);
                } else {
                    $item->$key = $path;
                }
            }
        }

        foreach ($this->changelog as $change) {
            $type = $this->types[$change['key']];

            if ($change['type'] == 'file') {
                switch ($change["action"]) {
                    case 'delete':
                        if (isset($type['foreign'])) {
                            $foreignFile = $type['foreign'];
                            $model = $foreignFile['model'];
                            $foreign_key = $foreignFile['key'];
                            $foreign_name = $foreignFile['name'];

                            $model
                                ::where($foreign_key, $id)
                                ->where("id", $change['id'])->delete();

                            $file = $change['id'];
                            $file = str_replace('/storage', 'public', $file);
                            Storage::delete($file);
                        } else {
                            $file = $item->{$change['key']};
                            $file = str_replace('/storage', 'public', $file);
                            Storage::delete($file);
                        }
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        $item->save();
        if (in_array('afterSave', $this->events)) {
            $this->afterSave($item, $this->data);
        }

        $this->handleCrudActions($this->name, [
            'action' => $this->data['id'] ? 'update' : 'create',
            'data' => $item->toArray(),
        ]);

        $this->Modal('save', false);
        $this->emit('toast', 'success', $this->Name . ' ' . __('toast-lang.savedsuccessfully'));
    }
    public function delete()
    {
        $this->Modal('delete', false);
        $item = $this->Model::find($this->data['id']);

        foreach ($this->foreigns as $foreign) {
            $items = $item->$foreign;
            if (count($items) != 0) {
                $this->modals['error'] = true;
                $this->emit('toast', 'error', __('toast-lang.cannotdelete') . ' ' . __(strtolower($item->{$this->mainKey})) . ' ' . __('toast-lang.because') . ' ' . __('toast-lang.has') . ' ' . __('toast-lang.' . $foreign));
                return;
            }
        }

        foreach ($this->types as $key => $type) {
            if ($type['type'] != 'file') {
                continue;
            }

            $files = $item->$key;
            if (gettype($files) == 'string') {
                $file = $files;
                $file = str_replace('/storage', 'public', $file);
                Storage::delete($file);
            } elseif (isset($this->types[$key]['foreign'])) {
                $foreignFile = $this->types[$key]['foreign'];
                $model = $foreignFile['model'];
                $foreign_key = $foreignFile['key'];
                $foreign_name = $foreignFile['name'];

                foreach ($files as $file) {
                    $_file = $file->$foreign_name;
                    $_file = str_replace('/storage', 'public', $_file);

                    Storage::delete($_file);

                    $model
                        ::where($foreign_key, $item->id)
                        ->where($foreign_name, $file[$foreign_name])
                        ->delete();
                }
            }
        }

        if (in_array('beforeDelete', $this->events)) {
            $this->beforeDelete($item);
        }

        $item->delete();

        $this->handleCrudActions($this->name, [
            'action' => 'delete',
            'data' => $this->data,
        ]);

        $this->emit('toast', 'success', $this->Name . ' ' . __('toast-lang.deletedsuccessfully'));
    }

    public function parseValue($value)
    {
        switch (gettype($value)) {
            case 'array':
                return implode(', ', $value);

            default:
                return $value;
        }
    }
}
