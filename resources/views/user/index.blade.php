<x-app-layout>
    <div class="container w-full mx-auto ">
        <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
            <div class="overflow-x-auto mx-4">
                <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
                    <div class="w-full">
                        <div class=" shadow-md rounded my-6">
                            <table class="min-w-max w-full table-auto">
                                <thead>
                                <tr class="bg-gray-600 text-gray-200 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">name</th>
                                    <th class="py-3 px-6 text-left">email</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-200 text-sm font-light">
                                @foreach ($users as $movie)
                                    @if($movie->hasRole('user'))
                                    <tr class="border-b border-gray-800 hover:bg-gray-900">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="mr-2">
                                                    <a
                                                        class="block hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150"
                                                        @if ($loop->last) @keydown.tab="isOpen = false" @endif
                                                    >
                                                        <div class="mr-2">
                                                            @if ($movie->picture)
                                                                <img
                                                                    src="@if(file_exists("img/".$movie->picture)) /img/{{$movie->picture}} @else {{$movie->picture}}@endif"
                                                                    alt="picture" class="w-10 h-10 rounded-full">
                                                            @else
                                                                <img src="https://via.placeholder.com/50x75" alt="poster"
                                                                     class="w-8">
                                                            @endif
                                                        </div>

                                                        <span class="ml-4">{{ $movie->name }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center">
                                                <span>{{ $movie->email }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center">
                                                <div x-data="{ open: false }">
                                                    <!-- Button (blue), duh! -->
                                                    <button
                                                        class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" @click="open = true">

                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                             viewBox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                    <!-- Dialog (full screen) -->

                                                    <div
                                                        class="absolute top-0 left-0 flex items-center justify-center w-full h-full"
                                                        style="background-color: rgba(0,0,0,.5);" x-show="open">
                                                        <!-- A basic modal dialog with title, body and one button to close -->
                                                        <div
                                                            class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0"
                                                            @click.away="open = false">
                                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                <div class="sm:flex sm:items-start">
                                                                    <div
                                                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                        <!-- Heroicon name: outline/exclamation -->
                                                                        <svg class="h-6 w-6 text-red-600"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             fill="none" viewBox="0 0 24 24"
                                                                             stroke="currentColor" aria-hidden="true">
                                                                            <path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  stroke-width="2"
                                                                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                                        </svg>
                                                                    </div>
                                                                    <div
                                                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                        <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                                            id="modal-title">
                                                                            Delete user
                                                                        </h3>
                                                                        <div class="mt-2">
                                                                            <p class="text-sm text-gray-500">
                                                                                Are you sure want to delete?
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                <form action="" method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit"
                                                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                        OK
                                                                    </button>
                                                                </form>
                                                                <button @click="open = false" type="button"
                                                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                    Cancel
                                                                </button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
