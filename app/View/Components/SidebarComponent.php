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

        "more",

        "customers" => [
            "icon" => "brief-case",
            "route" => "tenant.customers.show",
            "permission" => "tenant.customers.show",
        ],
        "products" => [
            "icon" => "shopping-bag",
            "route" => "tenant.products.show",
            "permission" => "tenant.products.show",
        ],
        "spaces" => [
            "icon" => "map-pin",
            "route" => "tenant.spaces.show",
            "permission" => "tenant.spaces.show",
        ],

        "payments" => [
            "icon" => "bank-notes",
            "route" => "tenant.payments.show",
            "permission" => "tenant.payments.show",
        ],
        "users" => [
            "icon" => "user-group",
            "route" => "tenant.users.show",
            "permission" => "tenant.users.show",
        ],

        'App',

        "tenants" => [
            "icon" => "home-modern",
            "route" => "app.tenants",
            "permission" => "app.tenants.show",
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
