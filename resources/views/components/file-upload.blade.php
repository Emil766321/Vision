<div class="flex flex-col flex-grow mb-3 w-11/12 m-auto">
    <div x-data="{ files: [] }" id="FileUpload"
        class="block w-full py-2 px-3 bg-white appearance-none border-2 border-gray-300 border-solid rounded-md hover:shadow-outline-gray"
        @dragover.prevent="$el.classList.add('active')" @dragleave="$el.classList.remove('active');"
        @drop.prevent="$el.classList.remove('active'); files = Array.from(event.dataTransfer.files);">
        <div class="relative h-fit">
            <input type="file" multiple class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                @change="files = Array.from([...files, ...$event.target.files])" name="image">
            <div class="flex flex-col space-y-2 items-center justify-center">
                <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                <p class="text-gray-700">
                    Drag your files here or click in this area.
                </p>
                <p
                    class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700">
                    Select a file
                </p>
            </div>
        </div>
        <template x-if="files.length > 0">
            <div class="flex flex-col space-y-1">
                <template x-for="(file,index) in files" :key="index">
                    <div class="flex flex-row items-center space-x-2">
                        <span class="font-medium text-gray-900" x-text="file.name" x-log="file">
                            Uploading
                        </span>
                        <span class="text-xs self-end text-gray-500" x-text="file.size">
                            ...
                        </span>
                        <button type="button" class="text-red-500" @click="files.splice(index, 1)">
                            remove
                        </button>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>
