<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public string $for;
    public string $class;
    public string $id;


    public function __construct($for, $id = '', $class = '')
    {
        $this->id = $id;
        $this->class = $class;
        $this->for = $for;
    }

    public function render(): Factory|\Illuminate\Foundation\Application|View|Htmlable|string|Closure|Application
    {
        return view('components.label');
    }
}
