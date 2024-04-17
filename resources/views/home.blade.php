<x-app-layout>
    <x-app-big-title>
        <h1 class="mt-8 text-wrap text-4xl md:text-5xl font-semibold text-gray-950 xl:text-5xl xl:[line-height:1.125]">
            AI-Powered <br class="hidden sm:block">Image Classification Hub
        </h1>
        <p class="text-wrap mx-auto mt-8 max-w-2xl text-lg text-gray-700 hidden sm:block">
            Organize Your Visual Content with Precision.
        </p>
        <p class="text-wrap mx-auto mt-10 max-w-2xl text-lg text-gray-700 hidden sm:block">
            Welcome to our cutting-edge image classification platform driven by AI. Effortlessly sort and categorize your images with unparalleled accuracy, empowering your content management tasks like never before. Experience the future of organization with our intuitive interface and advanced algorithms.
        </p>
        <div class="mt-8 flex flex-col items-center justify-center gap-4">
            <a href={{ route('image-recognition') }} class="transition-colors shadow-2xl text-xl text-white py-4 px-10 border-black border-solid border-2 rounded-2xl bg-black hover:border-black hover:text-black hover:bg-white">
                Try It Now !
            </a>
        </div>
    </x-app-big-title>
</x-app-layout>
