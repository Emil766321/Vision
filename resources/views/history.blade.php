<x-app-layout>
    <x-app-title>
        <h1 class="mt-8 text-wrap text-4xl md:text-5xl font-semibold text-gray-950 xl:text-5xl xl:[line-height:1.125]">
            History
        </h1>
        <p class="text-wrap mx-auto mt-8 max-w-2xl text-lg text-gray-700 hidden sm:block">
            Here is all the images you have upload
        </p>
    </x-app-title>
    <div class="w-100 flex justify-around my-14">
        <div class="w-2/4 flex flex-col">
            @if($images->isEmpty())
            <div class="w-100 min-h-96 my-4">
                <div class="h-full flex flex-col m-4">
                    <div class="w-full flex flex-row justify-around my-4">
                        <p>You have not uploaded images yet.</p>
                    </div>
                    <div class="my-4 flex flex-col items-center justify-center gap-4">
                        <a href={{ route('image-recognition') }} class="transition-colors shadow-2xl text-xl text-white py-4 px-10 border-black border-solid border-2 rounded-2xl bg-black hover:border-black hover:text-black hover:bg-white">
                            Upload now !
                        </a>
                    </div>
                </div>
            </div>
            @else
                @foreach ($images as $item)
                    <div class="w-100 min-h-96 my-4 rounded-lg shadow-md">
                        <div class="h-full flex flex-row justify-around m-4">
                            <div class="h-full flex flex-col justify-around">
                                <img src="{{ asset($item->image) }}" alt="Img" class="h-[200px]"/>
                            </div>
                            <div class="h-full flex flex-col justify-around">
                                <p>Uploaded : {{$item->created_at}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
