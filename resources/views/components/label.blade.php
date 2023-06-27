@props([
    'for' => '',
    'class' => '',
    'id' => '',
])

<label for="{{ $for }}" class="text-sm font-medium text-slate-700 {{ $class }}" id="{{ $id }}">{{ $slot }}</label>
