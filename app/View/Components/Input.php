<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $name;
    public string $type;
    public string $id;
    public string $class;
    public string $placeholder;
    public string $value;


    public function __construct($name = '', $type = 'text', $id = '', $class = '', $placeholder = '', $value = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->id = $id;
        $this->class = $class;
        $this->placeholder = $placeholder;
        $this->value = $value;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Htmlable|Closure|string|Application
    {
        return view('components.input');
    }
}
