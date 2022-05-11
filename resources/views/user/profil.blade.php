<x-app-layout>
    <div class="movie-info border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <div class="flex-none ">
                <img
                    src="@if(file_exists("img/".Auth::user()->picture )) /img/{{ Auth::user()->picture }} @else {{ Auth::user()->picture }} @endif"
                    alt="poster"
                    class="w-64 lg:w-96 rounded-full">
            </div>
            <div class="md:ml-24">
                <h2 class="text-4xl mt-4 md:mt-0 font-semibold">{{ Auth::user()->name }}</h2>
                <div class="flex flex-wrap items-center text-gray-400 text-lg">
                    <i class="far fa-envelope text-lg"></i>
                    <span class="ml-4">{{ Auth::user()->email}}</span>

                    <span>

                    </span>
                </div>

                <h4 class="text-white text-lg font-semibold mt-12">Favourite movies</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                    @foreach (Auth::user()->farvorites as $fav)
                        @if($fav->movie_id!=null && $fav->favorite)
                            <a href="{{ route('show', $fav->movie->id) }}">
                                <div class="mt-4">
                                    <img
                                        src="@if(file_exists("img/".$fav->movie->poster)) /img/{{$fav->movie->poster}} @else {{$fav->movie->poster}} @endif"
                                        alt="poster" class="hover:opacity-75 transition ease-in-out duration-150">
                                    <span
                                        class="text-sm leading-normal block text-gray-400 hover:text-white mt-1">{{ $fav->movie->title}}</span>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
                <h4 class="text-white text-lg font-semibold mt-12">Favourite series</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                    @foreach (Auth::user()->farvorites as $fav)
                        @if($fav->serie_id!=null && $fav->favorite)
                            <a href="{{ route('show2', $fav->serie->id) }}">
                                <div class="mt-4">
                                    <img
                                        src="@if(file_exists("img/".$fav->serie->poster)) /img/{{$fav->serie->poster}} @else {{$fav->serie->poster}} @endif"
                                        alt="poster" class="hover:opacity-75 transition ease-in-out duration-150">
                                    <span
                                        class="text-sm leading-normal block text-gray-400 hover:text-white mt-1">{{ $fav->serie->title}}</span>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
                <h4 class="text-white text-lg font-semibold mt-12">Favourite actors</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                    @foreach (Auth::user()->farvorites as $fav)
                        @if($fav->actor_id!=null && $fav->favorite)
                            <a href="{{ route('actor.show', $fav->actor->id) }}">
                                <div class="mt-4">
                                    <img
                                        src="@if(file_exists("img/".$fav->actor->picture)) /img/{{$fav->actor->picture}} @else {{$fav->actor->picture}} @endif"
                                        alt="poster" class="hover:opacity-75 transition ease-in-out duration-150">
                                    <span
                                        class="text-sm leading-normal block text-gray-400 hover:text-white mt-1">{{ $fav->actor->name}}</span>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    </div> <!-- end movie-info -->
</x-app-layout>
