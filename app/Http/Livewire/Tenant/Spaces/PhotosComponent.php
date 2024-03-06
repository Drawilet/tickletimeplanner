<?php

namespace App\Http\Livewire\Tenant\Spaces;

use App\Models\SpacePhoto;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotosComponent extends Component
{

    use WithFileUploads;
    protected $listeners = ['update-data' => 'handleData'];

    public $uploadedPhotos;

    public $data = [
        'id' => null,
    ], $files = ["photos" => []];

    public function handleData($data)
    {
        if (!isset($data['id']))
            return;

        $this->data['id'] = $data['id'];

        $this->files['photos'] = SpacePhoto::where('space_id', $data['id'])
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.tenant.spaces.photos-component');
    }
    public function updatedUploadedPhotos()
    {
        if (!isset($this->uploadedPhotos))
            return;

        if (!isset($this->files['photos'])) {
            $this->files['photos'] = [];
        }

        if (is_array($this->uploadedPhotos)) {
            foreach ($this->uploadedPhotos as $photo) {
                if (!in_array($photo->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                    $this->emit("toast", "error", __("toast-lang.invalid-file"));
                    continue;
                }

                array_push($this->files['photos'], ['url' => $photo->temporaryUrl(), 'photo' => $photo->getRealPath()]);
            }
        } else {
            if (!in_array($this->uploadedPhotos->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                $this->emit("toast", "error", "Invalid file type");
                return;
            }

            array_push($this->files['photos'], ['url' => $this->uploadedPhotos->temporaryUrl(), 'photo' => $this->uploadedPhotos->getRealPath()]);
        }

        $this->uploadedPhotos = null;

        $this->emit('update-files', ['photos' => $this->files['photos']]);
    }

    public function delete($key)
    {
        $id = $this->files['photos'][$key]['id'] ?? null;

        unset($this->files['photos'][$key]);
        $this->files['photos'] = array_values($this->files['photos']);

        $this->emit('update-files', ['photos' => $this->files['photos']]);

        if ($id) {
            $this->emit(
                'update-changelog',
                ['id' => $id, 'action' => 'delete', "key" => "photos", 'type' => 'file']
            );
        }
    }
}
