@props([
    'value' => '',
    'type' => 'text',
    'placeholder' => '',
    'name' => '',
    'id' => '',
    'class' => '',
    'error' => '',
    'label' => $name,

])


@if($error != '')
    <x-label for="{{ $name }}">{{$label}}</x-label>
    <x-input name="{{ $name }}" id="{{ $name }}" placeholder="{{$placeholder}}" value="{{ $value }}" class="border-red-500"></x-input>
    <x-error>{{ $error }}</x-error>
@else
    <x-label for="{{ $name }}">{{$label}}</x-label>
    <x-input name="{{ $name }}" id="{{ $name }}" placeholder="{{$placeholder}}" value="{{ $value }}"></x-input>
@endif
