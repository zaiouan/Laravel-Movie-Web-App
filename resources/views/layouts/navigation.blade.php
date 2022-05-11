<style>
    .bg-black-alt  {
        background:#191919;
    }
    .text-black-alt  {
        color:#191919;
    }
    .border-black-alt {
        border-color: #191919;
    }

</style>
<nav class="border-b border-gray-800">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between px-4 py-6">
        @auth
            <ul class="flex flex-col md:flex-row items-center">
            <li>
                <a href="">
                    <svg class="w-12" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                </a>
            </li>
            <li class="md:ml-16 mt-3 md:mt-0">
                <a href=" {{route('movie')}} "  class="hover:text-gray-300">@if (Auth::user()->hasRole('admin')) Movies(TMDB API) @else Movies @endif</a>
            </li>
            <li class="md:ml-6 mt-3 md:mt-0">
                <a href="  {{route('serie')}} " class="hover:text-gray-300">@if (Auth::user()->hasRole('admin')) TV Shows(TMDB API) @else TV Shows @endif</a>
            </li>
            <li class="md:ml-6 mt-3 md:mt-0">
                <a href=" {{route('actor')}}" class="hover:text-gray-300">@if (Auth::user()->hasRole('admin')) Actors(TMDB API) @else Actors @endif</a>
            </li>
        </ul>
        @role('admin')
        <div class="flex flex-col md:flex-row items-center">
            <livewire:search>
        </div>
         @endrole
            @role('user')
        <div class="flex flex-col md:flex-row items-center">
            <livewire:search-mv>
        </div>
         @endrole
        @endauth
        @guest
        <div class="flex flex-col md:flex-row items-center">
            <ul class="flex flex-col md:flex-row items-center">
                <li class="md:ml-16 mt-3 md:mt-0">
                    <a href="{{route('login')}}" class="hover:text-gray-300">Login</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{route('register')}}" class="hover:text-gray-300">Register</a>
                </li>
            </ul>
        </div>
        @endguest
        @auth
            <div class="flex flex-col md:flex-row items-center">
                <div class="flex relative inline-block float-right">
                <div class="relative text-sm text-gray-100">
                    <button id="userButton" class="flex items-center focus:outline-none mr-3">
                        <img class="w-8 h-8 rounded-full mr-4" src="@if(file_exists("img/".Auth::user()->picture )) /img/{{ Auth::user()->picture }} @else {{ Auth::user()->picture }} @endif" alt="Avatar of User"> <span class="hidden md:inline-block text-gray-100">Hi, {{ Auth::user()->name }}</span>
                        <svg class="pl-2 h-2 fill-current text-gray-100" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129"><g><path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/></g></svg>
                    </button>
                    <div id="userMenu" class="bg-gray-900 rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                        <ul class="list-reset">
                            <li><a href="{{route('dashboard.profil')}}" class="px-4 py-2 block text-gray-100 hover:bg-gray-800 no-underline hover:no-underline">My account</a></li>
                            <li><hr class="border-t mx-2 border-gray-400"></li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                            <li class="block px-4 py-2 text-sm leading-5 text-gray-100 hover:bg-gray-800 no-underline hover:no-underline '"><button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" >Logout</button></li>
                            </form>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
        @endauth
    </div>
</nav>
@role('admin')
<div class=" px-4 w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-gray-900 z-20"
     id="nav-content">
    <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
        <li class="mr-6 my-2 md:my-0">
            <a href="/dashboard"
               class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-blue-100 border-b-2 border-gray-900  hover:border-blue-400 @if(Route::is('dashboard')) border-blue-400 text-blue-400 @endif">
                <i class="fas fa-home fa-fw mr-3 "></i><span class="pb-1 md:pb-0 text-sm">Home</span>
            </a>
        </li>
        <li class="mr-6 my-2 md:my-0">
            <a href="{{route('movies')}}"
               class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-pink-400 @if(Route::is('movies')) border-pink-400 text-pink-400 @endif">
                <i class="fas fa-film fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Movies</span>
            </a>
        </li>
        <li class="mr-6 my-2 md:my-0">
            <a href="{{route('series')}}"
               class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-purple-400 @if(Route::is('series')) border-purple-400 text-purple-400 @endif">
                <i class="fas fa-tv fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Series TV</span>
            </a>
        </li>
        <li class="mr-6 my-2 md:my-0">
            <a href="{{route('actors.index')}}"
               class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-green-400 @if(Route::is('actors.index')) border-green-400 text-green-400 @endif">
                <i class="fas fa-user-tie fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Actors</span>
            </a>
        </li>
        <li class="mr-6 my-2 md:my-0">
            <a href="{{route('user.index')}}"
               class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-red-400 @if(Route::is('user.index')) border-red-400 text-red-400 @endif">
                <i class="fa fa-users fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Users</span>
            </a>
        </li>
    </ul>
</div>
@endrole
<script>


    /*Toggle dropdown list*/
    /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

    var userMenuDiv = document.getElementById("userMenu");
    var userMenu = document.getElementById("userButton");

    var navMenuDiv = document.getElementById("nav-content");
    var navMenu = document.getElementById("nav-toggle");

    document.onclick = check;

    function check(e){
        var target = (e && e.target) || (event && event.srcElement);

        //User Menu
        if (!checkParent(target, userMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, userMenu)) {
                // click on the link
                if (userMenuDiv.classList.contains("invisible")) {
                    userMenuDiv.classList.remove("invisible");
                } else {userMenuDiv.classList.add("invisible");}
            } else {
                // click both outside link and outside menu, hide menu
                userMenuDiv.classList.add("invisible");
            }
        }

        //Nav Menu
        if (!checkParent(target, navMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, navMenu)) {
                // click on the link
                if (navMenuDiv.classList.contains("hidden")) {
                    navMenuDiv.classList.remove("hidden");
                } else {navMenuDiv.classList.add("hidden");}
            } else {
                // click both outside link and outside menu, hide menu
                navMenuDiv.classList.add("hidden");
            }
        }

    }

    function checkParent(t, elm) {
        while(t.parentNode) {
            if( t == elm ) {return true;}
            t = t.parentNode;
        }
        return false;
    }


</script>
