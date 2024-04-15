<x-app-layout>
    <div class="-mx-6 relative mt-8 sm:mt-12 max-w-xl sm:mx-auto">
        <div class="absolute inset-0 -top-8 left-1/2 -z-20 h-56 w-full -translate-x-1/2 [background-image:linear-gradient(to_bottom,transparent_98%,theme(colors.gray.200/75%)_98%),linear-gradient(to_right,transparent_94%,_theme(colors.gray.200/75%)_94%)] [background-size:16px_35px] [mask:radial-gradient(black,transparent_95%)]"></div>
        <div class="absolute top-12 inset-x-0 w-2/3 h-1/3 -z-[1] rounded-full bg-primary-300 mx-auto blur-3xl"></div>
    </div>
    <section class="relative">
        <div class="relative pt-24 lg:pt-28">
            <div class="mx-auto px-6 max-w-7xl md:px-12">
                <div class="text-center sm:mx-auto sm:w-10/12 lg:mr-auto lg:mt-0 lg:w-4/5">
                    <h1 class="mt-8 text-wrap text-4xl md:text-5xl font-semibold text-gray-950 xl:text-5xl xl:[line-height:1.125]">
                        History
                    </h1>
                    <p class="text-wrap mx-auto mt-8 max-w-2xl text-lg text-gray-700 hidden sm:block">
                        Here is all the images you have upload
                    </p>
                </div>
            </div>
        </div>
    </section>
    <div class="w-100 flex justify-around my-14">
        <div class="w-2/4 flex flex-col">
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
        </div>
    </div>
</x-app-layout>
