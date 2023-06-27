@props([
    'class' => '',
    'id' => '',
])
@if($slot != '')
    <p class="text-red-500 text-xs {{$class}}" id="{{$id}}">{{$slot}}</p>
@endif

