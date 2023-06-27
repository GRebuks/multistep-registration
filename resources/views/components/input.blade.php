@props([
    'value' => '',
    'type' => 'text',
    'placeholder' => '',
    'name' => '',
    'id' => '',
    'class' => '',
])

<input name="{{ $name }}" id="{{ $id }}" type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ $value }}" class="bg-white w-full border border-slate-300 rounded-md py-2 pl-2 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm {{$class}}">
