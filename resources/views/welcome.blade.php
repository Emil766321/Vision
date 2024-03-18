@extends('layouts.home_layout')

@section('home_content')
<div class="w-full h-screen flex flex-col justify-around">
    <div class="flex flex-row justify-around h-full">
        <div class="flex flex-col justify-around">
            <div class="rounded-lg w-96 h-1/2 shadow-lg">
                <div class="flex flex-col justify-around h-full">
                    <h1 class="text-3xl text-Test font-bold text-center p-5">
                        Hello World !
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
