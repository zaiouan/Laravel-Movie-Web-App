<x-app-layout>
    <div class="movie-info border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <div class="flex-none">
                <img src="@if(file_exists("img/".$actor->picture)) /img/{{$actor->picture}} @else {{$actor->picture}} @endif" alt="profile image" class="w-76">
            </div>
            <div class="md:ml-24">
                <div class="flex">
                    <div class="flex-1"><h2 class="text-4xl font-semibold">{{$actor->name}}  </h2></div>
                    <div class="flex-none ml-96 pl-32 text-3xl">
                    @role('user')
                   <livewire:favorite-actor :rec="$actor->id" />
                    @endrole
                    </div>
                </div>

                <h4 class="font-semibold mt-12">Known For</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                    @foreach ($actor->movies as $movie)
                        @if($loop->index<20)
                            <div class="mt-4">
                                @if($movie->poster)
                                <a href="{{route('show',$movie->id)}}">
                                    <img src="{{ $movie->poster }}" alt="poster"
                                                class="hover:opacity-75 transition ease-in-out duration-150">
                                    @else
                                        <img src="https://via.placeholder.com/50x75" alt="poster"
                                             class="w-8">
                                    @endif
                                </a>

                                <a href=""
                                   class="text-sm leading-normal block text-gray-400 hover:text-white mt-1">{{$movie->title}}</a>
                            </div>
                        @endif
                    @endforeach
                    @foreach ($actor->series as $movie)
                        @if($loop->index<20)
                            <div class="mt-4">
                                <a href=""><img src="@if(file_exists("img/".$movie->poster)) /img/{{$movie->poster}} @else {{$movie->poster}} @endif" alt="poster"
                                                class="hover:opacity-75 transition ease-in-out duration-150"></a>
                                <a href=""
                                   class="text-sm leading-normal block text-gray-400 hover:text-white mt-1">{{$movie->title}}</a>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div> <!-- end movie-info -->

    <div class="credits border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">Credits</h2>
            <ul class="list-disc leading-loose pl-5 mt-8">
                @foreach ($actor->movies as $movie)
                    @if($loop->index<20)
                        <li>
                            {{ \Carbon\Carbon::parse($movie->date)->format('Y') }} &middot;
                            <strong><a
                                    href=""
                                    class="hover:underline"> {{$movie->title}}</a></strong>
                            as
                            <?php $character = \App\Models\actor_movie::where('movie_id', $movie->id)->where('actor_id', $actor->id)->get(); ?>
                            @foreach($character as $character)
                                {{$character->character}}
                            @endforeach
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div> <!-- end credits-->
</x-app-layout>
