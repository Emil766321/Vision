<x-app-layout>
    @foreach ($images as $item)
        <img src="{{ asset($item->image) }}" alt="Img"/>
    @endforeach
</x-app-layout>
