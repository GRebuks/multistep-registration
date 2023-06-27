@props([
    'class' => '',
])

<button type="submit" class="py-2 px-4 rounded-full border border-red-200 text-sm font-semibold bg-red-100 text-red-600 hover:bg-red-200 w-60 {{$class}}">{{$slot}}</button>
