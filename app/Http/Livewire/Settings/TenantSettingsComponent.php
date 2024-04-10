<?php

namespace App\Http\Livewire\Settings;

use App\Http\Traits\WithValidations;
use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class TenantSettingsComponent extends Component
{
    use WithFileUploads, WithValidations;

    public $data,
    $initialData = [
        'background_image' => '',
        'profile_image' => '',

        'name' => '',
        'description' => '',
        'phone' => '',
        'email' => '',
    ];

    public function mount()
    {
        $data = Auth()->user()->tenant;
        if ($data) {
            $this->data = $data->toArray();
        } else {
            $this->data = $this->initialData;
        }
    }
    public function render()
    {
        return view('livewire.settings.tenant-settings-component');
    }

    public function save()
    {
        Validator::make($this->data, [
            'profile_image' => isset($this->data['id']) ? '' : 'required|image|max:2048',
            'background_image' => isset($this->data['id']) ? '' : 'required|image|max:2048',

            'name' => $this->validations['text'],
            'description' => $this->validations['textarea'],
            'phone' => $this->validations['tel'],
            'email' => $this->validations['email'],
            /*    'social_nets' => 'required', */
        ])->validate();

        $tenant = Tenant::updateOrCreate(['id' => Auth()->user()->tenant->id ?? null], $this->data);

        foreach (['profile_image', 'background_image'] as $type) {
            if (gettype($this->data[$type]) == 'object') {
                $fileName = $this->data[$type]->getClientOriginalName();
                $path = '/tenant/' . $tenant->id . "/$type";

                $this->data[$type]->storeAs('/public' . $path, $fileName);

                $tenant[$type] = '/storage' . $path . '/' . $fileName;
            }
        }

        $tenant->save();

        $user = Auth()->user();
        if (!$user->tenant) {
            $user->tenant_id = $tenant->id;
            $user->wizard_step = 1;
            $user->save();

            $user->assignRole('tenant.admin');

            redirect()->route('dashboard.show');
        }

        $this->emit('toast', 'success', 'Data saved successfully');
    }
}
