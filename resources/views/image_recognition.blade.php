<x-app-layout>
<div class="-mx-6 relative mt-8 sm:mt-12 max-w-xl sm:mx-auto">
    <div class="absolute inset-0 -top-8 left-1/2 -z-20 h-56 w-full -translate-x-1/2 [background-image:linear-gradient(to_bottom,transparent_98%,theme(colors.gray.200/75%)_98%),linear-gradient(to_right,transparent_94%,_theme(colors.gray.200/75%)_94%)] [background-size:16px_35px] [mask:radial-gradient(black,transparent_95%)]"></div>
    <div class="absolute top-12 inset-x-0 w-2/3 h-1/3 -z-[1] rounded-full mx-auto blur-3xl"></div>
</div>
<section class="relative h-[100vh] mb-28">
    <div class="relative pt-24 lg:pt-28">
        <div class="mx-auto px-6 max-w-7xl md:px-12">
            <div class="text-center sm:mx-auto sm:w-10/12 lg:mr-auto lg:mt-0 lg:w-4/5">
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
                        <form action="/image-recognition" method="post" class="block w-full" enctype='multipart/form-data'>
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
            </div>
        </div>
    </div>
</section>

{{-- <img src="../../storage/images/test/cat.jpeg" alt="Picture of a st bernard "> --}}
</x-app-layout>
