<x-app-layout>
    <x-app-big-title>
        <h1 class="mt-8 text-wrap text-4xl md:text-5xl font-semibold text-gray-950 xl:text-5xl xl:[line-height:1.125]">Try It Now!</h1>
        <p class="text-wrap mx-auto mt-8 max-w-2xl text-lg text-gray-700 hidden sm:block">
            Upload a jpg, a jpeg or a zip file with multiple jpg and jpeg and observe the magic happens.
        </p>
        <div class="mt-8 flex flex-col items-center justify-center gap-4">
            <div class="shadow-lg px-5 py-20 rounded-lg mt-28 w-[50%]">
                @if(isset($error))
                    <div class="m-1 mb-16 border-red-100 border-solid border-2 bg-red-100 text-red-500 rounded-md py-1">
                        {{$error}}
                    </div>
                @endif
                <form action={{ route('image-recognition') }} method="post" class="block w-full" enctype='multipart/form-data'>
                    @csrf
                    <input type="file" name="image">
                    <div class="mt-8 flex flex-col items-center justify-center gap-4">
                        <button type="submit" class="transition-colors shadow-2xl text-xl text-white py-4 px-10 border-black border-solid border-2 rounded-2xl bg-black hover:border-black hover:text-black hover:bg-white">
                            Classer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-app-big-title>

{{-- <img src="../../storage/images/test/cat.jpeg" alt="Picture of a st bernard "> --}}
</x-app-layout>
