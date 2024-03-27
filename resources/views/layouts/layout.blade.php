<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Immage Classification</title>
        <meta name="description" content="Image clssification with AI" />
        @vite('resources/css/app.css')
    </head>

    <body class="bg-white dark:bg-gray-950">
        <header>
            <nav class="fixed overflow-hidden z-20 w-full bg-white/80 dark:bg-gray-950/75 dark:shadow-md dark:shadow-gray-950/10 border-b border-[--ui-light-border-color] border-x dark:border-[--ui-dark-border-color] backdrop-blur">
                <div class="px-6 m-auto max-w-6xl 2xl:px-0">
                    <div class="flex flex-wrap items-center justify-around sm:py-4">
                        <div class="w-full h-0 lg:w-fit flex-wrap justify-end items-center space-y-8 lg:space-y-0 lg:flex lg:h-fit md:flex-nowrap">
                            <div class="mt-6 text-gray-600 dark:text-gray-300 md:-ml-4 lg:pr-4 lg:mt-0">
                                <ul class="space-y-6 tracking-wide text-base lg:text-sm lg:flex lg:space-y-0">
                                    <li>
                                        <a href="/" class="block md:px-4 transition hover:text-black">
                                            <span>Home</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/image-recognition" class="block md:px-4 transition hover:text-black">
                                            <span>Classify Images</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="w-full space-y-2 gap-2 pt-6 pb-4 lg:pb-0 border-t border-[--ui-light-border-color] dark:border-[--ui-dark-border-color] items-center flex flex-col lg:flex-row lg:space-y-0 lg:w-fit lg:border-l lg:border-t-0 lg:pt-0 lg:pl-2">
                                <button class="w-full h-9 lg:w-fit group flex items-center rounded-md text-gray-800 hover:bg-gray-100 active:bg-gray-200/75 lg:text-sm lg:h-8 px-3.5 justify-center">
                                    <span>Login</span>
                                </button>
                                <button class=" text-dark border-black border-solid border-1 rounded-md hover:bg-gray-100 w-full h-9 lg:w-fit group flex items-center relative border round lg:text-sm lg:h-8 px-3 justify-center">
                                    <span>Sign Up</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main class="overflow-hidden">

            @yield('content')

        </main>
        <footer class="rounded-xl border">
            <div class="max-w-6xl mx-auto px-6 py-16 text-gray-600 2xl:px-0 justify-around flex">
                <span class="text-gray-600 dark:text-gray-400">&copy; Emilien Charpié 2024 - Pré-TPI</span>
            </div>
        </footer>
    </body>
</html>

