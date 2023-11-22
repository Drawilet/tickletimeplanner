<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    public  $code, $description, $quantity, $price, $id_product;
    public $modal, $data;
    use WithPagination;

    
    public $query = '';
  
    public function search()
    {
        $this->resetPage();
    }
 
    public function render()
    {

        return view('livewire.product-component',
  
       [
            "products" => Product::where('code', 'like', '%' . $this->query . '%')
                ->orWhere('description', 'like', '%' . $this->query . '%')
                ->orderBy('id')
                ->paginate('2')
        ]
    
    );
   
        
    }
    public function create()
    {
        $this->limpiarCampos();
        $this->abrirModal();
    }

    public function abrirModal()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }
    public function limpiarCampos()
    {
        $this->code = "";
        $this->description = "";
        $this->quantity = "";
        $this->id_product = "";
        $this->price = "";
    }
    public function edit($id)
    {
        $allproducts = Product::findOrFail($id);
        $this->id_product = $id;
        $this->description = $allproducts->description;
        $this->quantity = $allproducts->quantity;
        $this->price = $allproducts->price;
        $this->code = $allproducts->code;
        $this->abrirModal();
    }
    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Registro eliminado correctamente');
    }
    public function save()
    {
        Product::updateOrCreate(
            ['id' => $this->id_product],
            [
                'quantity' => $this->quantity,
                'description' => $this->description,
                'code' => $this->code,
                'price' => $this->price
            ]
        );
        session()->flash(
            'message',
            $this->id_product ? 'Actulizacion exitosa' : 'Alta exitosa'
        );
        $this->cerrarModal();
        $this->limpiarCampos();
    }
    
}
