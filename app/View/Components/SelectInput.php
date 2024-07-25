<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectInput extends Component
{
    public $label;

    /**
     * Create a new component instance.
     * 
     * @param string|null $label
     * @return void
     */
    public function __construct($label = null)
    {
        $this->label = $label ?? "Default Label";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.select-input');
    }
}
