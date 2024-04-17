<x-app-layout>
    <x-app-big-title>
        <h1 class="mt-8 text-wrap text-4xl md:text-5xl font-semibold text-gray-950 xl:text-5xl xl:[line-height:1.125]">And see the results!</h1>
        <p class="text-wrap mx-auto mt-8 max-w-2xl text-lg text-gray-700 hidden sm:block">
            Upload a jpg, a jpeg or a zip file with multiple jpg and jpeg and observe the magic happens.
        </p>
        <div class="mt-5 flex flex-col items-center justify-center gap-4">
            <div class="text-left shadow-lg px-5 py-20 rounded-lg mt-28 w-[50%]">
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
                <div class="mt-8 flex flex-col items-center justify-center gap-4">
                    <a href={{ route('image-recognition') }} class="transition-colors shadow-2xl text-xl text-white py-4 px-10 border-black border-solid border-2 rounded-2xl bg-black hover:border-black hover:text-black hover:bg-white">
                        Go back
                    </a>
                </div>
            </div>
        </div>
    </x-app-big-title>

{{-- <img src="../../storage/images/test/cat.jpeg" alt="Picture of a st bernard "> --}}

</x-app-layout>
