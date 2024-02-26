<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BrowserMockupComponent extends Component
{
    public $locale;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->locale = app()->getLocale();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.browser-mockup-component');
    }
}
