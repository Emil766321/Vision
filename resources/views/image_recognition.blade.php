@extends('layouts.image_recognition_layout')

@section('content')

<div class="w-full h-screen flex flex-col justify-around">
    <div class="flex flex-row justify-around h-full">
        <div class="flex flex-col justify-around">
            <div class="rounded-lg w-96 h-1/2 shadow-lg">
                <div class="flex flex-col justify-around h-full p-10">
                    <form action="/image-recognition" method="post" class="block" enctype='multipart/form-data'>
                        @csrf
                        <input type="file" name="image">
                        <button type="submit" class=" mt-3 p-1 border-black border-solid border-2 rounded-md">Classer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="classifier">
    {{-- <img src="{{asset('storage/images/St_bernard.jpeg');}}" alt="Picture of a st bernard "> --}}
</div>

@endsection
