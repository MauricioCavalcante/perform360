<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxInput extends Component
{
    public $checked;

    /**
     * Create a new component instance.
     *
     * @param bool $checked
     * @return void
     */
    public function __construct($checked = false)
    {
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkbox-input');
    }
}
