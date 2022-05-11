<x-app-layout>

    <div class="container w-full mx-auto pt-20">
        @if (session('status'))
            <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-green-500">
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
        <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

            <!--Console Content-->

            <div class="flex flex-wrap">
                <div class="w-full md:w-1/2 xl:w-1/2 p-3">
                    <!--Metric Card-->
                    <div class="bg-gray-900 border border-gray-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600">
                                    <i
                                        class="fas fa-film fa-2x fa-fw fa-inverse"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="font-bold uppercase text-gray-400">Total Movies</h5>
                                <h3 class="font-bold text-3xl text-gray-600">{{\App\Models\Movie::count()}}</h3>
                            </div>
                            <div x-data="{ isOpen: false }">
                                <div>
                                    <button
                                        @click="isOpen = true"
                                        class="flex inline-flex items-center text-gray-900 rounded font-semibold  transition ease-in-out duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-12 w-12 text-gray-100 fill-current"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>

                                <template x-if="isOpen">
                                    <div
                                        style="background-color: rgba(0, 0, 0, .5);"
                                        class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                                    >
                                        <div class="container lg:px-32 rounded-lg overflow-y-auto">
                                            <div class="bg-white rounded">
                                                <div class="flex justify-end pr-4 pt-2">
                                                    <button
                                                        @click="isOpen = false"
                                                        @keydown.escape.window="isOpen = false"
                                                        class="text-3xl leading-none hover:text-gray-300">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body px-8 py-8">
                                                    <div class="responsive-container overflow-hidden relative">
                                                        <h1 class="text-2xl mx-auto font-bold mb-8">Add movie</h1>
                                                        <form id="form" novalidate method="post"
                                                              action="{{route('movie.store')}}"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="flex flex-row space-x-4">
                                                                <div class="relative z-0 w-full mb-5 ">
                                                                    <input
                                                                        type="text"
                                                                        name="title"
                                                                        placeholder=""
                                                                        required
                                                                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <label for="name"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">title</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">Name is required</span>
                                                                </div>
                                                                <div class="relative z-0 w-full mb-5">
                                                                    <input
                                                                        type="number"
                                                                        name="vote"
                                                                        placeholder=""
                                                                        class="pt-3 pb-2 pl-5 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <div
                                                                        class="absolute top-0 right-4 mt-3 ml-1 text-gray-400">
                                                                        %
                                                                    </div>
                                                                    <label for="vote"
                                                                           class="absolute duration-300 top-3 left-5 -z-1 origin-0 text-gray-500">Vote</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">Vote is required</span>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-row space-x-4">
                                                                <div class="relative z-0 w-full mb-5 ">
                                                                    <div
                                                                        class="pt-10 pb-3 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 ">
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox  h-5 w-5 text-gray-600"
                                                                                   name="genres[]" value="action"><span
                                                                                class="ml-2 text-gray-700">Action</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-red-600"
                                                                                   name="genres[]"
                                                                                   value="Adventure"><span
                                                                                class="ml-2 text-gray-700">Adventure</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-orange-600"
                                                                                   name="genres[]"
                                                                                   value="Animation"><span
                                                                                class="ml-2 text-gray-700">Animation</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-yellow-600"
                                                                                   name="genres[]" value="Comedy"><span
                                                                                class="ml-2 text-gray-700">Comedy</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-green-600"
                                                                                   name="genres[]"
                                                                                   value="Documentary"><span
                                                                                class="ml-2 text-gray-700">Documentary</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-gray-600"
                                                                                   name="genres[]" value="Drama"><span
                                                                                class="ml-2 text-gray-700">Drama</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-blue-600"
                                                                                   name="genres[]" value="Fantasy"><span
                                                                                class="ml-2 text-gray-700">Fantasy</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-red-600"
                                                                                   name="genres[]" value="History"><span
                                                                                class="ml-2 text-gray-700">History</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-green-600"
                                                                                   name="genres[]" value="Horror"><span
                                                                                class="ml-2 text-gray-700">Horror</span>
                                                                        </label>
                                                                    </div>
                                                                    <label for="genre"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Genre</label>
                                                                </div>
                                                                <div x-data="imageViewer()"
                                                                     class="relative z-0 w-full mb-5 ">
                                                                    <!-- Show the image -->
                                                                    <template x-if="imageUrl">
                                                                        <img :src="imageUrl"
                                                                             class="object-cover rounded border border-gray-200"
                                                                             style="width: 100px; height: 100px;"
                                                                        >
                                                                    </template>

                                                                    <!-- Show the gray box when image is not available -->
                                                                    <template x-if="!imageUrl">
                                                                        <div
                                                                            class="border rounded border-gray-200 bg-gray-100"
                                                                            style="width: 100px; height: 100px;"
                                                                        ></div>
                                                                    </template>

                                                                    <!-- Image file selector -->
                                                                    <input class="mt-2" name="image" type="file"
                                                                           accept="image/*"
                                                                           @change="fileChosen">

                                                                </div>
                                                            </div>
                                                            <div class="relative z-0 w-full mb-5 ">
                                                                <label
                                                                    class="text-sm text-gray-600">Content</label></br>
                                                                <textarea name="content"
                                                                          class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"></textarea>
                                                                <span class="text-sm text-red-600 hidden"
                                                                      id="error">Date is required</span>
                                                            </div>
                                                            <div class="flex flex-row space-x-4">
                                                                <div class="relative z-0 w-full mb-5">
                                                                    <input
                                                                        type="text"
                                                                        name="date"
                                                                        placeholder=" "
                                                                        onclick="this.setAttribute('type', 'date');"
                                                                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <label for="date"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">release
                                                                        date</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">Date is required</span>
                                                                </div>
                                                                <div class="relative z-0 w-full mb-5 ">
                                                                    <input
                                                                        type="text"
                                                                        name="trailer"
                                                                        value="https://www.youtube.com/watch?v="
                                                                        required
                                                                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <label for="trailer"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Trailer
                                                                        link</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">link is required</span>
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-end items-center w-100">
                                                                <button
                                                                    class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white">
                                                                    Add
                                                                </button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/2 p-3">
                    <!--Metric Card-->
                    <div class="bg-gray-900 border border-gray-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-pink-600"><i class="fas fa-users fa-2x fa-fw fa-inverse"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="font-bold uppercase text-gray-400">Total Users</h5>
                                <h3 class="font-bold text-3xl text-gray-600">{{\App\Models\User::whereRoleIs('user')->count()}}</h3>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

                <div class="w-full md:w-1/2 xl:w-1/2 p-3">
                    <!--Metric Card-->
                    <div class="bg-gray-900 border border-gray-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-blue-600"><i
                                        class="fas fa-tv fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="font-bold uppercase text-gray-400">Total Series</h5>
                                <h3 class="font-bold text-3xl text-gray-600">{{\App\Models\Serie::count()}}</h3>
                            </div>
                            <div x-data="{ isOpen: false }">
                                <div>
                                    <button
                                        @click="isOpen = true"
                                        class="flex inline-flex items-center text-gray-900 rounded font-semibold  transition ease-in-out duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-12 w-12 text-gray-100 fill-current"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>

                                <template x-if="isOpen">
                                    <div
                                        style="background-color: rgba(0, 0, 0, .5);"
                                        class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                                    >
                                        <div class="container lg:px-32 rounded-lg overflow-y-auto">
                                            <div class="bg-white rounded">
                                                <div class="flex justify-end pr-4 pt-2">
                                                    <button
                                                        @click="isOpen = false"
                                                        @keydown.escape.window="isOpen = false"
                                                        class="text-3xl leading-none hover:text-gray-300">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body px-8 py-8">
                                                    <div class="responsive-container overflow-hidden relative">
                                                        <h1 class="text-2xl mx-auto font-bold mb-8">Add serie</h1>
                                                        <form id="form" novalidate method="post"
                                                              action="{{route('serie.store')}}"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="flex flex-row space-x-4">
                                                                <div class="relative z-0 w-full mb-5 ">
                                                                    <input
                                                                        type="text"
                                                                        name="title"
                                                                        placeholder=""
                                                                        required
                                                                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <label for="name"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">title</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">Name is required</span>
                                                                </div>
                                                                <div class="relative z-0 w-full mb-5">
                                                                    <input
                                                                        type="number"
                                                                        name="vote"
                                                                        placeholder=""
                                                                        class="pt-3 pb-2 pl-5 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <div
                                                                        class="absolute top-0 right-4 mt-3 ml-1 text-gray-400">
                                                                        %
                                                                    </div>
                                                                    <label for="vote"
                                                                           class="absolute duration-300 top-3 left-5 -z-1 origin-0 text-gray-500">Vote</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">Vote is required</span>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-row space-x-4 ">
                                                                <div class="relative z-0 w-full mb-5 ">
                                                                    <div
                                                                        class="pt-10 pb-3 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 ">
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox  h-5 w-5 text-gray-600"
                                                                                   name="genres[]" value="action"><span
                                                                                class="ml-2 text-gray-700">Action</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-red-600"
                                                                                   name="genres[]"
                                                                                   value="Adventure"><span
                                                                                class="ml-2 text-gray-700">Adventure</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-orange-600"
                                                                                   name="genres[]"
                                                                                   value="Animation"><span
                                                                                class="ml-2 text-gray-700">Animation</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-yellow-600"
                                                                                   name="genres[]" value="Comedy"><span
                                                                                class="ml-2 text-gray-700">Comedy</span>
                                                                        </label>

                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-green-600"
                                                                                   name="genres[]"
                                                                                   value="Documentary"><span
                                                                                class="ml-2 text-gray-700">Documentary</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-gray-600"
                                                                                   name="genres[]" value="Drama"><span
                                                                                class="ml-2 text-gray-700">Drama</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-blue-600"
                                                                                   name="genres[]" value="Fantasy"><span
                                                                                class="ml-2 text-gray-700">Fantasy</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-red-600"
                                                                                   name="genres[]" value="History"><span
                                                                                class="ml-2 text-gray-700">History</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center ">
                                                                            <input type="checkbox"
                                                                                   class="form-checkbox h-5 w-5 text-green-600"
                                                                                   name="genres[]" value="Horror"><span
                                                                                class="ml-2 text-gray-700">Horror</span>
                                                                        </label>
                                                                    </div>
                                                                    <label for="genre"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Genre</label>
                                                                </div>
                                                                <div x-data="imageViewer()"
                                                                     class="relative z-0 w-full mb-5 ">
                                                                    <!-- Show the image -->
                                                                    <template x-if="imageUrl">
                                                                        <img :src="imageUrl"
                                                                             class="object-cover rounded border border-gray-200"
                                                                             style="width: 100px; height: 100px;"
                                                                        >
                                                                    </template>

                                                                    <!-- Show the gray box when image is not available -->
                                                                    <template x-if="!imageUrl">
                                                                        <div
                                                                            class="border rounded border-gray-200 bg-gray-100"
                                                                            style="width: 100px; height: 100px;"
                                                                        ></div>
                                                                    </template>

                                                                    <!-- Image file selector -->
                                                                    <input class="mt-2" name="image" type="file"
                                                                           accept="image/*"
                                                                           @change="fileChosen">

                                                                </div>
                                                            </div>
                                                            <div class="relative z-0 w-full mb-5 ">
                                                                <label
                                                                    class="text-sm text-gray-600">Content</label></br>
                                                                <textarea name="content"
                                                                          class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"></textarea>
                                                                <span class="text-sm text-red-600 hidden"
                                                                      id="error">Date is required</span>
                                                            </div>
                                                            <div class="flex flex-row space-x-4">
                                                                <div class="relative z-0 w-full mb-5">
                                                                    <input
                                                                        type="text"
                                                                        name="date"
                                                                        placeholder=" "
                                                                        onclick="this.setAttribute('type', 'date');"
                                                                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <label for="date"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">first
                                                                        air date</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">Date is required</span>
                                                                </div>
                                                                <div class="relative z-0 w-full mb-5 ">
                                                                    <input
                                                                        type="text"
                                                                        name="trailer"
                                                                        value="https://www.youtube.com/watch?v="
                                                                        required
                                                                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                    />
                                                                    <label for="trailer"
                                                                           class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Trailer
                                                                        link</label>
                                                                    <span class="text-sm text-red-600 hidden"
                                                                          id="error">link is required</span>
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-end items-center w-100">
                                                                <button
                                                                    class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white">
                                                                    Add
                                                                </button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/2 p-3">
                    <!--Metric Card-->
                    <div class="bg-gray-900 border border-gray-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-indigo-600">
                                    <i class="fas fa-user-tie fa-2x fa-fw fa-inverse"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="font-bold uppercase text-gray-400">Total Actors</h5>
                                <h3 class="font-bold text-3xl text-gray-600">{{\App\Models\Actor::count()}}</h3>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
            </div>

            <!--Divider-->
            <hr class="border-b-2 border-gray-600 my-8 mx-4">


        </div>

    </div>
    @section('scripts')
        <script>
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

            function dropdown() {
                return {
                    options: [],
                    selected: [],
                    show: false,
                    open() {
                        this.show = true
                    },
                    close() {
                        this.show = false
                    },
                    isOpen() {
                        return this.show === true
                    },
                    select(index, event) {

                        if (!this.options[index].selected) {

                            this.options[index].selected = true;
                            this.options[index].element = event.target;
                            this.selected.push(index);

                        } else {
                            this.selected.splice(this.selected.lastIndexOf(index), 1);
                            this.options[index].selected = false
                        }
                    },
                    remove(index, option) {
                        this.options[option].selected = false;
                        this.selected.splice(index, 1);


                    },
                    loadOptions() {
                        const options = document.getElementById('select').options;
                        for (let i = 0; i < options.length; i++) {
                            this.options.push({
                                value: options[i].value,
                                text: options[i].innerText,
                                selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                            });
                        }


                    },
                    selectedValues() {
                        return this.selected.map((option) => {
                            return this.options[option].value;
                        })
                    }
                }
                var openmodal = document.querySelectorAll('.modal-open')
                for (var i = 0; i < openmodal.length; i++) {
                    openmodal[i].addEventListener('click', function (event) {
                        event.preventDefault()
                        toggleModal()
                    })
                }

                const overlay = document.querySelector('.modal-overlay')
                overlay.addEventListener('click', toggleModal)

                var closemodal = document.querySelectorAll('.modal-close')
                for (var i = 0; i < closemodal.length; i++) {
                    closemodal[i].addEventListener('click', toggleModal)
                }

                document.onkeydown = function (evt) {
                    evt = evt || window.event
                    var isEscape = false
                    if ("key" in evt) {
                        isEscape = (evt.key === "Escape" || evt.key === "Esc")
                    } else {
                        isEscape = (evt.keyCode === 27)
                    }
                    if (isEscape && document.body.classList.contains('modal-active')) {
                        toggleModal()
                    }
                };


                function toggleModal() {
                    const body = document.querySelector('body')
                    const modal = document.querySelector('.modal')
                    modal.classList.toggle('opacity-0')
                    modal.classList.toggle('pointer-events-none')
                    body.classList.toggle('modal-active')
                }


            }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript">
            var i = 0;
            $("#dynamic-ar").click(function () {
                ++i;
                $("#dynamicAddRemove").append('<tr><td><input type="text" name="addMoreInputFields[' + i +
                    '][subject]" placeholder="Enter subject" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" /></td><td><button type="button" class="bg-red-500">Delete</button></td></tr>'
                );
            });
            $(document).on('click', '.remove-input-field', function () {
                $(this).parents('tr').remove();
            });
        </script>
        <script>
            'use strict'

            document.getElementById('button').addEventListener('click', toggleError)
            const errMessages = document.querySelectorAll('#error')

            function toggleError() {
                // Show error message
                errMessages.forEach((el) => {
                    el.classList.toggle('hidden')
                })

                // Highlight input and label with red
                const allBorders = document.querySelectorAll('.border-gray-200')
                const allTexts = document.querySelectorAll('.text-gray-500')
                allBorders.forEach((el) => {
                    el.classList.toggle('border-red-600')
                })
                allTexts.forEach((el) => {
                    el.classList.toggle('text-red-600')
                })
            }
        </script>
    @endsection

</x-app-layout>

