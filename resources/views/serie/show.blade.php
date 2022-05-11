
<x-app-layout>
    <div class="serie-info border-b border-gray-800">
        @if (session('status'))
            <div class="text-white px-6 py-4 border-0 rounded-sm relative mb-4 bg-green-500">
              <span class="text-xl inline-block mr-5 align-middle">
                <i class="fas fa-bell"></i>
              </span>
                <span class="inline-block align-middle mr-8">
                <b class="capitalize">{{session('status')}}</b>
              </span>
                <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none" onclick="closeAlert(event)">
                    <span>×</span>

                </button>
            </div>
            <script>
                function closeAlert(event){
                    let element = event.target;
                    while(element.nodeName !== "BUTTON"){
                        element = element.parentNode;
                    }
                    element.parentNode.parentNode.removeChild(element.parentNode);
                }
            </script>
        @endif
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <div class="flex-none">
                <img
                    src="@if(file_exists("img/".$movie->poster)) /img/{{$movie->poster}} @else {{$movie->poster}} @endif"
                    alt="poster"
                    class="w-64 lg:w-96">
            </div>
            <div class="md:ml-24">
                <div class="flex">
                    <div class="flex-1 "><h2 class="text-4xl font-semibold">{{$movie->title}}  </h2></div>
                    <div class="flex-none ml-96  text-3xl">
                        @role('user')
                        <livewire:favorite-serie :rec="$movie->id" />
                        @endrole
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
                    <span class="ml-1">{{$movie->vote * 10 ."%"}}</span>
                    <span class="mx-2">|</span>
                    <span>{{\Carbon\Carbon::parse($movie->date)->format('M d, Y') }}</span>
                    <span class="mx-2">|</span>
                    <span>
                        @foreach($movie->genres as $genre)
                            {{$genre->name}} @if(!$loop->last ), @endif
                        @endforeach
                    </span>
                </div>

                <p class="text-gray-300 mt-8">
                    {{ $movie->overview }}
                </p>

                <div class="mt-12">
                    <h4 class="text-white font-semibold">Featured Crew</h4>
                    @if($movie->crews)

                        <div class="flex mt-4">
                            @foreach ($movie->crews as $crew)
                                @if($loop->index < 2)
                                    <div class="mr-8">
                                        <div>{{ $crew->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $crew->job }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex mt-4">
                            @else
                                <div class="mt-6" x-data="{ open: false }">

                                    <button
                                        class="bg-blue-500 text-white px-4 py-2 rounded no-outline focus:shadow-outline select-none"
                                        @click="open = true">Add Crews
                                    </button>
                                    <form action="{{route('crew.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$movie->id}}" name="id">
                                        <div
                                            class="absolute top-0 left-0 w-full h-full flex items-center justify-center"
                                            style="background-color: rgba(0,0,0,.5);" x-show="open">
                                            <div
                                                class=" bg-white h-auto w-auto p-1 md:max-w-xl  shadow-xl rounded md:mx-0"
                                                @click.away="open = false">
                                                <h2 class="text-2xl text-gray-900 text-3xl mb-5">Add Crews</h2>
                                                <div class="text-gray-900" x-data="handler()">
                                                    <div class="w-auto h-auto">
                                                        <table class=" min-w-full divide-y divide-gray-800">
                                                            <thead class="bg-gray-800">
                                                            <tr>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                                    #
                                                                </th>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                                    Name
                                                                </th>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                                    Job
                                                                </th>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                                    Remove
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <template x-for="(field, index) in fields" :key="index">
                                                                <tr>
                                                                    <td x-text="index + 1"></td>
                                                                    <td><input x-model="field.txt1" type="text"
                                                                               name="txt1[]"
                                                                               class="form-control"></td>
                                                                    <td><input x-model="field.txt2" type="text"
                                                                               name="txt2[]"
                                                                               class="form-control"></td>
                                                                    <td>
                                                                        <button type="button"
                                                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                                                @click="removeField(index)">&times;
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <td colspan="4" class="text-right">
                                                                    <button type="button"
                                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                                                            @click="addNewField()">+ Add Row
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="flex justify-center mt-8">
                                                    <button
                                                        class="bg-green-700 text-white px-4 py-2 rounded no-outline focus:shadow-outline select-none"
                                                        @click="open = false">Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div x-data="{ isOpen: false }">
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

                                    <template x-if="isOpen">
                                        <div
                                            style="background-color: rgba(0, 0, 0, .5);"
                                            class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
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
                                                        <div class="responsive-container overflow-hidden relative"
                                                             style="padding-top: 56.25%">
                                                            <iframe
                                                                class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                                                src="{{$movie->trailer_link}}?autoplay=1&mute=1"
                                                                style="border:0;" encrypted-media"
                                                            allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                        </div>
                </div>
            </div> <!-- end movie-info -->

            <div class="movie-cast border-b border-gray-800">
                <div class="container mx-auto px-4 py-16">
                    <h2 class="text-4xl font-semibold">Cast</h2>
                    @if(\App\Models\actor_movie::where('serie_id',$movie->id)->whereNotNull('actor_id')->exists())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                            @foreach ($movie->actors as $cast)
                                <div class="mt-8">
                                    <a href="{{route('actor.show' ,$cast->id)}}">
                                        <img
                                            src=" @if(file_exists("img/".$cast->picture)) /img/{{$cast->picture }} @else {{$cast->picture }} @endif"
                                            alt="actor1"
                                            class="hover:opacity-75 transition ease-in-out duration-150">
                                    </a>
                                    <div class="mt-2">
                                        <a href="" class="text-lg mt-2 hover:text-gray:300">{{ $cast->name }}</a>
                                        <div class="text-sm text-gray-400">
                                            <?php $character = \App\Models\actor_movie::where('serie_id', $movie->id)->where('actor_id', $cast->id)->get(); ?>
                                            @foreach($character as $character)
                                                {{$character->character}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="mt-6" x-data="{ open: false }">

                            <button
                                class="bg-blue-500 text-white px-4 py-2 rounded no-outline focus:shadow-outline select-none"
                                @click="open = true">Add actors
                            </button>
                            <form action="{{route('actor.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$movie->id}}" name="id">
                                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center"
                                     style="background-color: rgba(0,0,0,.5);" x-show="open">
                                    <div class=" bg-white h-auto w-auto p-1  shadow-xl rounded "
                                         @click.away="open = false">
                                        <h2 class="text-2xl text-gray-900 w-auto text-3xl mb-5">Add Actors</h2>
                                        <div class="text-gray-900 w-auto" x-data="handler()">
                                            <div class="w-auto h-auto">
                                                <table class=" min-w-full divide-y divide-gray-800">
                                                    <thead class="bg-gray-800">
                                                    <tr>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                            #
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                            Name
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                            Character
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                            Picture
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                            Remove
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <template x-for="(field, index) in fields" :key="index">
                                                        <tr>
                                                            <td x-text="index + 1"></td>
                                                            <td><input x-model="field.txt1" type="text" name="txt1[]"
                                                                       class="form-control"></td>
                                                            <td><input x-model="field.txt2" type="text" name="txt2[]">
                                                            </td>
                                                            <td>
                                                                <input x-model="field.txt3" class="mt-2" name="images[]"
                                                                       class="form-control " type="file"
                                                                       accept="image/*"
                                                                       @change="fileChosen">
                                                            </td>
                                                            <td class="items-center">
                                                                <button type="button"
                                                                        class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                                        @click="removeField(index)">&times;
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-right">
                                                            <button type="button"
                                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                                                    @click="addNewField()">+ Add Row
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="flex justify-center mt-8">
                                            <button
                                                class="bg-gray-700 text-white px-4 py-2 rounded no-outline focus:shadow-outline select-none"
                                                @click="open = false">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div> <!-- end movie-cast -->

            <div class="movie-images" x-data="{ isOpen: false, image: ''}">
                <div class="container mx-auto px-4 py-16">
                    <h2 class="text-4xl font-semibold">Images</h2>
                    @if(\App\Models\Image::where('serie_id',$movie->id)->exists())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                            @foreach ($movie->images as $image)
                                <div class="mt-8">
                                    <a
                                        @click.prevent="
                                isOpen = true
                                image='@if(file_exists("img/".$image->link)) /img/{{ $image->link }} @else {{ $image->link }} @endif'
                            "
                                        href="#"
                                    >
                                        <img
                                            src="@if(file_exists("img/".$image->link)) /img/{{ $image->link }} @else {{ $image->link }} @endif"
                                            alt="image1"
                                            class="hover:opacity-75 transition ease-in-out duration-150">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else

                        <div class="mt-6" x-data="{ open: false }">
                            <button
                                class="bg-blue-500 text-white px-4 py-2 rounded no-outline focus:shadow-outline select-none"
                                @click="open = true">Add images
                            </button>
                            <div class="relative top-0 left-0 w-full h-full flex items-center justify-center"
                                 style="background-color: rgba(0,0,0,.5);" x-show="open">
                                <main class="container mx-auto max-w-screen-lg h-full">
                                    <div class="flex justify-end pr-4 pt-2">
                                        <button
                                            @click="open = false"
                                            @keydown.escape.window="open = false"
                                            class="text-3xl leading-none hover:text-gray-300">&times;
                                        </button>
                                    </div>
                                    <!-- file upload modal -->
                                    <article aria-label="File Upload Modal"
                                             class="relative h-full flex flex-col bg-white shadow-xl rounded-md"
                                             ondrop="dropHandler(event);" ondragover="dragOverHandler(event);"
                                             ondragleave="dragLeaveHandler(event);"
                                             ondragenter="dragEnterHandler(event);">
                                        <!-- overlay -->
                                        <div id="overlay"
                                             class="w-full h-full absolute top-0 left-0 pointer-events-none z-50 flex flex-col items-center justify-center rounded-md">
                                            <i>
                                                <svg class="fill-current w-12 h-12 mb-3 text-blue-700"
                                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24">
                                                    <path
                                                        d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z"/>
                                                </svg>
                                            </i>
                                            <p class="text-lg text-blue-700">Drop files to upload</p>
                                        </div>

                                        <!-- scroll area -->
                                        <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">

                                            <header
                                                class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                                                <form id="upload" action="{{route('image.store')}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <p class="mb-3 font-semibold text-gray-900 flex flex-wrap justify-center">
                                                        <span>Drag and drop your</span>&nbsp;<span>files anywhere or</span>
                                                    </p>
                                                    <input type="hidden" value="{{$movie->id}} " name="id">
                                                    <input id="hidden-input" type="file" name="images[]" multiple
                                                           class="hidden"/>
                                                </form>
                                                <button id="button"
                                                        class="mt-2 rounded-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                                                    Upload a file
                                                </button>
                                            </header>

                                            <h1 class="pt-8 pb-3 font-semibold sm:text-lg text-gray-900">
                                                To Upload
                                            </h1>

                                            <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                                <li id="empty"
                                                    class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                                    <img class="mx-auto w-32"
                                                         src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                                         alt="no data"/>
                                                    <span class="text-small text-gray-500">No files selected</span>
                                                </li>
                                            </ul>
                                        </section>

                                        <!-- sticky footer -->
                                        <footer class="flex justify-end px-8 pb-8 pt-4">
                                            <button form="upload"
                                                    class="rounded-sm px-3 py-1 bg-blue-700 hover:bg-blue-500 text-white focus:shadow-outline focus:outline-none">
                                                Upload now
                                            </button>
                                            <button id="cancel"
                                                    class="ml-3 rounded-sm px-3 py-1 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                                                Cancel
                                            </button>
                                        </footer>
                                    </article>
                                </main>

                            </div>

                            <!-- using two similar templates for simplicity in js code -->
                            <template id="file-template">
                                <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                                    <article tabindex="0"
                                             class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline elative bg-gray-100 cursor-pointer relative shadow-sm">
                                        <img alt="upload preview"
                                             class="img-preview hidden w-full h-full sticky object-cover rounded-md bg-fixed"/>

                                        <section
                                            class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                            <h1 class="flex-1 group-hover:text-blue-800"></h1>
                                            <div class="flex">
              <span class="p-1 text-blue-800">
                <i>
                  <svg class="fill-current w-4 h-4 ml-auto pt-1" xmlns="http://www.w3.org/2000/svg" width="24"
                       height="24" viewBox="0 0 24 24">
                    <path d="M15 2v5h5v15h-16v-20h11zm1-2h-14v24h20v-18l-6-6z"/>
                  </svg>
                </i>
              </span>
                                                <p class="p-1 size text-xs text-gray-700"></p>
                                                <button
                                                    class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-800">
                                                    <svg class="pointer-events-none fill-current w-4 h-4 ml-auto"
                                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24">
                                                        <path class="pointer-events-none"
                                                              d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </section>
                                    </article>
                                </li>
                            </template>

                            <template id="image-template">
                                <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                                    <article tabindex="0"
                                             class="group hasImage w-full h-full rounded-md focus:outline-none focus:shadow-outline bg-gray-100 cursor-pointer relative text-transparent hover:text-white shadow-sm">
                                        <img alt="upload preview"
                                             class="img-preview w-full h-full sticky object-cover rounded-md bg-fixed"/>

                                        <section
                                            class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                            <h1 class="flex-1"></h1>
                                            <div class="flex">
                                          <span class="p-1">
                                            <i>
                                              <svg class="fill-current w-4 h-4 ml-auto pt-" xmlns="http://www.w3.org/2000/svg" width="24"
                                                   height="24" viewBox="0 0 24 24">
                                                <path
                                                    d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z"/>
                                              </svg>
                                            </i>
                                          </span>

                                                <p class="p-1 size text-xs"></p>
                                                <button
                                                    class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md">
                                                    <svg class="pointer-events-none fill-current w-4 h-4 ml-auto"
                                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24">
                                                        <path class="pointer-events-none"
                                                              d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </section>
                                    </article>
                                </li>
                            </template>
                        </div>
                </div>
                @endif
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
        </div>
        <script>
            const fileTempl = document.getElementById("file-template"),
                imageTempl = document.getElementById("image-template"),
                empty = document.getElementById("empty");

            // use to store pre selected files
            let FILES = {};

            // check if file is of type image and prepend the initialied
            // template to the target element
            function addFile(target, file) {
                const isImage = file.type.match("image.*"),
                    objectURL = URL.createObjectURL(file);

                const clone = isImage
                    ? imageTempl.content.cloneNode(true)
                    : fileTempl.content.cloneNode(true);

                clone.querySelector("h1").textContent = file.name;
                clone.querySelector("li").id = objectURL;
                clone.querySelector(".delete").dataset.target = objectURL;
                clone.querySelector(".size").textContent =
                    file.size > 1024
                        ? file.size > 1048576
                            ? Math.round(file.size / 1048576) + "mb"
                            : Math.round(file.size / 1024) + "kb"
                        : file.size + "b";

                isImage &&
                Object.assign(clone.querySelector("img"), {
                    src: objectURL,
                    alt: file.name
                });

                empty.classList.add("hidden");
                target.prepend(clone);

                FILES[objectURL] = file;
            }

            const gallery = document.getElementById("gallery"),
                overlay = document.getElementById("overlay");

            // click the hidden input of type file if the visible button is clicked
            // and capture the selected files
            const hidden = document.getElementById("hidden-input");
            document.getElementById("button").onclick = () => hidden.click();
            hidden.onchange = (e) => {
                for (const file of e.target.files) {
                    addFile(gallery, file);
                }
            };

            // use to check if a file is being dragged
            const hasFiles = ({dataTransfer: {types = []}}) =>
                types.indexOf("Files") > -1;

            // use to drag dragenter and dragleave events.
            // this is to know if the outermost parent is dragged over
            // without issues due to drag events on its children
            let counter = 0;

            // reset counter and append file to gallery when file is dropped
            function dropHandler(ev) {
                ev.preventDefault();
                for (const file of ev.dataTransfer.files) {
                    addFile(gallery, file);
                    overlay.classList.remove("draggedover");
                    counter = 0;
                }
            }

            // only react to actual files being dragged
            function dragEnterHandler(e) {
                e.preventDefault();
                if (!hasFiles(e)) {
                    return;
                }
                ++counter && overlay.classList.add("draggedover");
            }

            function dragLeaveHandler(e) {
                1 > --counter && overlay.classList.remove("draggedover");
            }

            function dragOverHandler(e) {
                if (hasFiles(e)) {
                    e.preventDefault();
                }
            }

            // event delegation to caputre delete events
            // fron the waste buckets in the file preview cards
            gallery.onclick = ({target}) => {
                if (target.classList.contains("delete")) {
                    const ou = target.dataset.target;
                    document.getElementById(ou).remove(ou);
                    gallery.children.length === 1 && empty.classList.remove("hidden");
                    delete FILES[ou];
                }
            };

            // print all selected files
            document.getElementById("submit").onclick = () => {
                alert(`Submitted Files:\n${JSON.stringify(FILES)}`);
                console.log(FILES);
            };

            // clear entire selection
            document.getElementById("cancel").onclick = () => {
                while (gallery.children.length > 0) {
                    gallery.lastChild.remove();
                }
                FILES = {};
                empty.classList.remove("hidden");
                gallery.append(empty);
            };

            function handler() {
                return {
                    fields: [],
                    addNewField() {
                        this.fields.push({
                            txt1: '',
                            txt2: '',
                            txt3: ''
                        });
                    },
                    removeField(index) {
                        this.fields.splice(index, 1);
                    }
                }
            }

            function imageViewer() {
                return {
                    imageUrl: '',

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            }

        </script>
</x-app-layout>
