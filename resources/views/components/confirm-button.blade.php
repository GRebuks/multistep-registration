@props([
    'class' => '',
])

<button type="submit" class=" py-2 px-4 rounded-full border border-sky-200 text-sm font-semibold bg-sky-100 text-sky-700 hover:bg-sky-200 w-60 {{$class}}">{{$slot}}</button>
