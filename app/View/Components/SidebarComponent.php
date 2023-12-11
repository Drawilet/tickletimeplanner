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
            "icon" => "brief-case",
            "route" => "tenant.customers.show"
        ],
        "Products" => [
            "icon" => "shopping-bag",
            "route" => "tenant.products.show"
        ],
        "Spaces" => [
            "icon" => "map-pin",
            "route" => "tenant.spaces.show"
        ],
        "Payments" => [
            "icon" => "bank-notes",
            "route" => "dashboard.show"
        ],
        "Users" => [
            "icon" => "user-group",
            "route" => "dashboard.show"
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
