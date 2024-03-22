@extends('layouts.image_recognition_layout')

@section('content')

@foreach ($class as $item)
<p>{{$item}}</p>
@endforeach
</br>
</br>
<a class="mt-5 p-1 border-black border-solid border-2 rounded-md" href="/image-recognition">Go back</a>

@endsection
