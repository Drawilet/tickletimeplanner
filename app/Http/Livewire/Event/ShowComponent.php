<?php

namespace App\Http\Livewire\Event;

use Livewire\Component;

class ShowComponent extends Component
{
    public $initialFilter = [
        "display_mode" => "table",
        "search" => ""
    ];
    public $filter;
    public $modal;

    public function mount()
    {
        $this->filter = $this->initialFilter;
    }

    public function render()
    {
        return view('livewire.event.show-component');
    }

    public function changeDisplayMode($mode)
    {
        $this->filter['display_mode'] = $mode;
    }

}
 /*LOGO RECTANGULO O TRIANGULAR
 NOMBRE DE LA EMPRESA, CONTACTO, CORREO, REDES SOCIALES
 CATALOGO DE SALONES
 DEBEN TENER WIZARD
 PRIMERO DEBE ESTAR SPACES LUEGO PRODCUTS Y LUEGO CUSTOMERS
 SE DEBE QUITAR LOS ELEMENTOS "CALENDARIO Y TABLA Y PONERLO EN EL NAVBAR"
 TABLA DE VENTAS
 POR SALON SE DEBE PONER EL MINIMO PARA ABONAR, DIAS ANTES PARA LIQUIDAR
*/
