<x-app-layout>
    <div class="container mx-auto px-4 py-16">
        <div class="popular-actors">
            <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Actors</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($actors as $actor)
                    <div class="actor mt-8">
                        <a href="{{ route('actor.show', $actor->id) }}">
                            <img src="{{ 'https://image.tmdb.org/t/p/w235_and_h235_face'.$actor->picture }}"
                                 alt="profile image"
                                 class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                        <div class="mt-2">
                            <a href="{{ route('actor.show', $actor->id) }}"
                               class="text-lg hover:text-gray-300">{{ $actor['name'] }}</a>
                            <div class="text-sm truncate text-gray-100">
                                    @foreach($actor->movies as $genre)

                                    {{$genre->title}} @if(!$loop->last )/ @endif
                                @endforeach
                                @foreach($actor->series as $genre)
                                    @if(!$loop->last )/ @endif {{$genre->title}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div> <!-- end popular-actors -->
        <div class="mt-5 bg-gray-900 text-gray-100">{{ $actors->links() }}</div>
    </div>
</x-app-layout>
