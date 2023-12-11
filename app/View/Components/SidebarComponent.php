<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarComponent extends Component
{
    public $sidebar = [
        
        "dashboard" => [
            "icon" => "home",
            "route" => "dashboard.show"
        ],

        "More",

        "customers" => [
            "icon" => "user-group",
            "route" => "tenant.customers.show"
        ],
        "spaces" => [
            "icon" => "map-pin",
            "route" => "tenant.spaces.show"
            
        ],
        "products" => [
            "icon" => "shopping-bag",
            "route" => "tenant.products.show"
        ],
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-component');
    }
}
