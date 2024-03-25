@extends('layouts.image_recognition_layout')

@section('content')

@for ($i = 0; $i < count($response); $i++)
    @if (isset($response[$i]['class']))
        @foreach ($response[$i]['class'] as $item)
            <p>{{$item}}</p>
        @endforeach
        </br>
    @endif
@endfor

@for ($i = 0; $i < count($response); $i++)
    @if (isset($response[$i]['text']) && $response[$i]['text'] != "")
    <p>Comment for image {{$i}} : {{$response[$i]['text']}}</p>
    @endif
@endfor

</br>
</br>
<a class="mt-5 p-1 border-black border-solid border-2 rounded-md" href="/image-recognition">Go back</a>

@endsection
