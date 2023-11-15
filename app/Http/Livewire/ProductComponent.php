<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductComponent extends Component
{
    public $allproducts, $code, $description, $quantity, $price, $id_product;
    public $modal;
    public function render()
    {
        $this->allproducts = Product::all();
        return view('livewire.product-component');
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
    {    $this->code = "";
        $this->description = "";
        $this->quantity = "";
        $this->id_product = "";
        $this->price = "";
    }
    public function edit($id)
    {
      $allproducts = Product::findOrFail($id);
      $this-> id_product = $id;
      $this->description = $allproducts->description;
      $this->quantity = $allproducts->quantity;
      $this->price = $allproducts->price;
      $this->code = $allproducts->code;
      $this->abrirModal();

    }
    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message','Registro eliminado correctamente');
    }
    public function save()
    {
        Product::updateOrCreate(['id'=>$this->id_product],
        [
            'quantity'=>$this->quantity,
            'description'=>$this->description,
            'code'=>$this->code,
            'price'=>$this->price
        ]);
        session()->flash('message',
         $this->id_product ? 'Actulizacion exitosa':'Alta exitosa'
    );
        $this->cerrarModal();
        $this->limpiarCampos();
    }
   

 }