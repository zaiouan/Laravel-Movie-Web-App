<x-app-layout>
    <form id="add" action="{{route('seriesapi.store')}}" method="post">
        @csrf
        <div class="movie-info border-b border-gray-800">
            <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
                <div class="flex-none">
                    <input type="hidden" name="picture"
                           value="https://image.tmdb.org/t/p/original/{{ $tvshow['poster_path'] }}">
                    <img src="https://image.tmdb.org/t/p/original/{{ $tvshow['poster_path'] }}" alt="poster"
                         class="w-64 lg:w-96">
                </div>
                <div class="md:ml-24 ">
                    <input type="hidden" name="title" value="{{ $tvshow['name'] }}">
                    <div class="flex">
                    <div class="flex-1"><h2 class="text-4xl mt-4 md:mt-0 font-semibold">{{ $tvshow['name'] }}</h2></div>
                        <div class="flex-none pl-96 ml-28">
                            <button
                                class="bg-transparent hover:bg-orange-500 text-orange-500 font-semibold hover:text-white py-2 px-4 border border-orange-500 hover:border-transparent rounded">
                                Add
                            </button>
                        </div>
                </div>
                    <div class="flex flex-wrap items-center text-gray-400 text-sm">
                        <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24">
                            <g data-name="Layer 2">
                                <path
                                    d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z"
                                    data-name="star"/>
                            </g>
                        </svg>
                        <input type="hidden" name="vote" value="{{ $tvshow['vote_average']}}">
                        <span class="ml-1">{{ $tvshow['vote_average'] * 10 ."%" }}</span>
                        <span class="mx-2">|</span>
                        <input type="hidden" name="date" value="{{ $tvshow['first_air_date'] }}">
                        <span>{{\Carbon\Carbon::parse($tvshow['first_air_date'])->format('M d, Y') }}</span>
                        <span class="mx-2">|</span>
                        <span>
                        @foreach($tvshow['genres'] as $genre)
                                <input type="hidden" name="genres[]" value="{{ $genre['name'] }}">
                                {{$genre['name']}} @if(!$loop->last ), @endif
                            @endforeach
                    </span>

                    </div>

                    <p class="text-gray-300 mt-8">
                        <input type="hidden" name="overview" value="{{ $tvshow['overview'] }}">
                        {{ $tvshow['overview'] }}
                    </p>
                    @if($tvshow['credits']['crew'])
                        <div class="mt-12">
                            <h4 class="text-white font-semibold">Featured Crew</h4>
                            <div class="flex mt-4">
                                @foreach ($tvshow['credits']['crew'] as $crew)
                                    @if($loop->index < 2)
                                        <div class="mr-8">
                                            <input type="hidden" name="crew_name[]" value="{{ $crew['name'] }}">
                                            <input type="hidden" name="job[]" value="{{ $crew['job'] }}">
                                            <div>{{ $crew['name'] }}</div>
                                            <div class="text-sm text-gray-400">{{ $crew['job'] }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <h4 class="text-white font-semibold mt-12">Seasons</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">

                        @foreach ($tvshow['seasons'] as $season)
                            @if($loop->index<20)
                                <div class="mt-4">
                                    <img src="{{ 'https://image.tmdb.org/t/p/w185'.$season['poster_path'] }}"
                                         alt="poster" class="hover:opacity-75 transition ease-in-out duration-150">
                                    <span
                                        class="text-sm leading-normal block text-gray-400 hover:text-white mt-1">{{ $season['name']." | ".$season['episode_count'] ." episodes"}}</span>
                                </div>
                            @endif
                        @endforeach

                    </div>

                    <div x-data="{ isOpen: false }">
                        @if (count($tvshow['videos']['results']) > 0)

                            <div class="mt-12">
                                <button
                                    @click="isOpen = true"
                                    class="flex inline-flex items-center bg-orange-500 text-gray-900 rounded font-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150"
                                >
                                    <svg class="w-6 fill-current" viewBox="0 0 24 24">
                                        <path d="M0 0h24v24H0z" fill="none"/>
                                        <path
                                            d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                    </svg>
                                    <span class="ml-2">Play Trailer</span>
                                </button>
                            </div>
                            <input type="hidden" name="link"
                                   value="https://www.youtube.com/embed/{{ $tvshow['videos']['results'][0]['key'] }}">
                            <template x-if="isOpen">
                                <div
                                    style="background-color: rgba(0, 0, 0, .5);"
                                    class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                                >
                                    <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                                        <div class="bg-gray-900 rounded">
                                            <div class="flex justify-end pr-4 pt-2">
                                                <button
                                                    type="button"
                                                    @click="isOpen = false"
                                                    @keydown.escape.window="isOpen = false"
                                                    class="text-3xl leading-none hover:text-gray-300">&times;
                                                </button>
                                            </div>

                                            <div class="modal-body px-8 py-8">
                                                <div class="responsive-container overflow-hidden relative"
                                                     style="padding-top: 56.25%">
                                                    <iframe
                                                        class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                                        src="https://www.youtube.com/embed/{{ $tvshow['videos']['results'][0]['key'] }}?autoplay=1&mute=1"
                                                        style="border:0;" allow="autoplay; encrypted-media"
                                                        allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        @endif


                    </div>

                </div>
            </div>
        </div> <!-- end movie-info -->

        <div class="movie-cast border-b border-gray-800">
            <div class="container mx-auto px-4 py-16">
                <h2 class="text-4xl font-semibold">Cast</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">

                    @foreach ($tvshow['credits']['cast'] as $cast)
                        @if($loop->index < 5)
                            <input type="hidden" name="actor_picture[]"
                                   value="{{'https://image.tmdb.org/t/p/w300/'. $cast['profile_path'] }}">
                            <input type="hidden" name="actor_name[]" value="{{ $cast['name'] }}">
                            <input type="hidden" name="actor_character[]" value="{{ $cast['character'] }}">
                            <div class="mt-8">
                                <a href="{{route('actorsapi.show',$cast['id'])}}">
                                    @if ($cast['profile_path'])
                                        <img src="{{'https://image.tmdb.org/t/p/w300/'. $cast['profile_path'] }}"
                                             alt="actor1"
                                             class="hover:opacity-75 transition ease-in-out duration-150">                                    @else
                                        <img src="https://via.placeholder.com/50x75" alt="poster"
                                             class="w-8">
                                    @endif
                                </a>
                                <div class="mt-2">
                                    <a href="" class="text-lg mt-2 hover:text-gray:300">{{ $cast['name'] }}</a>
                                    <div class="text-sm text-gray-400">
                                        {{ $cast['character'] }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div> <!-- end movie-cast -->

        <div class="movie-images" x-data="{ isOpen: false, image: ''}">
            <div class="container mx-auto px-4 py-16">
                <h2 class="text-4xl font-semibold">Images</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    @foreach ($tvshow['images']['backdrops'] as $image)
                        @if($loop->index < 9)
                            <input type="hidden" name="images[]"
                                   value="{{ 'https://image.tmdb.org/t/p/original/'.$image['file_path'] }}">
                            <div class="mt-8">
                                <a
                                    @click.prevent="
                                isOpen = true
                                image='{{ 'https://image.tmdb.org/t/p/original/'.$image['file_path'] }}'
                            "
                                    href="#"
                                >
                                    @if($image['file_path'])
                                        <img src="{{ 'https://image.tmdb.org/t/p/w500/'.$image['file_path'] }}"
                                             alt="image1" class="hover:opacity-75 transition ease-in-out duration-150">
                                    @else
                                        <img src="https://via.placeholder.com/50x75" alt="poster"
                                             class="w-8">
                                    @endif
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div
                    style="background-color: rgba(0, 0, 0, .5);"
                    class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                    x-show="isOpen"
                >
                    <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                        <div class="bg-gray-900 rounded">
                            <div class="flex justify-end pr-4 pt-2">
                                <button
                                    @click="isOpen = false"
                                    @keydown.escape.window="isOpen = false"
                                    class="text-3xl leading-none hover:text-gray-300">&times;
                                </button>
                            </div>
                            <div class="modal-body px-8 py-8">
                                <img :src="image" alt="poster">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end movie-images -->
    </form>
</x-app-layout>
