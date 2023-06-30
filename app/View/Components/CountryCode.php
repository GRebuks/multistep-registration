<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CountryCode extends Component
{
    public string $codeValue;
    public string $numberValue;

    public function __construct(string $codeValue = '', string $numberValue = '')
    {
        $this->codeValue = $codeValue;
        $this->numberValue = $numberValue;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Htmlable|Closure|string|Application
    {
        return view('components.country-code');
    }
}
