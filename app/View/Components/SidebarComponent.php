<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarComponent extends Component
{
    public $sidebar = [
        "Dashboard" => [
            "icon" => "home",
            "route" => "dashboard.show"
        ],

        "More",

        "Customers" => [
            "icon" => "user-group",
            "route" => "customers.show"
        ],
        "Spaces" => [
            "icon" => "map-pin",
            "route" => "spaces.show"
        ],
        "Products" => [
            "icon" => "shopping-bag",
            "route" => "products.show"
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
