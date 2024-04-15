<x-app-layout>
    @foreach ($images as $item)
        <img src="{{ asset($item->image) }}" alt="Img"/>
        <p>{{$item->created_at}}</p>
    @endforeach
</x-app-layout>
