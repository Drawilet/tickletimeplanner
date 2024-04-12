<?php

namespace App\Http\Livewire\Tenant;

use App\Http\Livewire\Util\CrudComponent;
use App\Models\Product;
use Auth;

class ProductsComponent extends CrudComponent
{
    public $events = ["afterSave"];

    public function mount()
    {
        $this->setup(Product::class, [
            'mainKey' => 'name',
            'types' => [
                'photo' => [
                    'type' => 'file',
                    'max' => 1,
                    'accept' => ['image/jpeg', 'image/png'],
                ],
                'name' => ['type' => 'text'],
                'description' => ['type' => 'textarea', 'rows' => 4],
                'cost' => ['type' => 'number'],
                'price' => ['type' => 'number'],
                'notes' => ['type' => 'textarea', 'rules' => 'nullable'],
            ],
            'mobileStyles' => "
                .photo {
                    width: 100%;
                    justify-content: center;
                    margin-bottom: 10px;
                }

                .photo img {
                   height: 200px;
                   width: 200px;
                }

                .name {
                    width: 100%;
                    justify-content: center;
                    font-size: 1.2rem;
                    margin-bottom: -8px;
                }

                .description {
                    width: 100%;
                    justify-content: center;
                    font-size: 1rem;
                }

                .cost, .price {
                    width: 50%;
                    justify-content: center;
                    font-size: 1rem;
                }

            ",
            'foreigns' => ['events'],
        ]);
    }

    public function afterSave($product, $data)
    {
        $user = Auth::user();
        $products = Product::where('tenant_id', $user->tenant_id)->get();

        if ($products->count() == 1) {
            $user = Auth::user();
            $user->wizard_step = 3;
            $user->save();

            return redirect()->route('tenant.products.show');
        }
    }
}
