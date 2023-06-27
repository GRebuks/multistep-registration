<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmButton extends Component
{
    public string $class;


    public function __construct($class = '')
    {
        $this->class = $class;
    }

    public function render(): Factory|\Illuminate\Foundation\Application|View|Htmlable|string|Closure|Application
    {
        return view('components.confirm-button');
    }
}
