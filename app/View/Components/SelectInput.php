<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectInput extends Component
{
    public $label;

    /**
     * Create a new component instance.
     *
     * @param  string|null  $label
     * @return void
     */
    public function __construct($label = null)
    {
        $this->label = $label ?? 'Default Label'; // Valor padrão se $label não for fornecido
    }

    public function render()
    {
        return view('components.select-input');
    }
}
