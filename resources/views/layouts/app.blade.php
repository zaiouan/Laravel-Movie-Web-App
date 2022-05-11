<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <livewire:styles />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <style>
            [x-cloak] { display: none; }

            .svg-icon {
                width: 1em;
                height: 1em;
            }

            .svg-icon path,
            .svg-icon polygon,
            .svg-icon rect {
                fill: #333;
            }

            .svg-icon circle {
                stroke: #4691f6;
                stroke-width: 1;
            }

            .-z-1 {
                z-index: -1;
            }

            .origin-0 {
                transform-origin: 0%;
            }

            input:focus ~ label,
            input:not(:placeholder-shown) ~ label,
            textarea:focus ~ label,
            textarea:not(:placeholder-shown) ~ label,
            select:focus ~ label,
            select:not([value='']):valid ~ label {
                /* @apply transform; scale-75; -translate-y-6; */
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                --tw-scale-x: 0.75;
                --tw-scale-y: 0.75;
                --tw-translate-y: -1.5rem;
            }

            input:focus ~ label,
            select:focus ~ label {
                /* @apply text-black; left-0; */
                --tw-text-opacity: 1;
                color: rgba(0, 0, 0, var(--tw-text-opacity));
                left: 0px;
            }
            .alert-toast {
                -webkit-animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            }

            /*Toast close animation*/
            .alert-toast input:checked ~ * {
                -webkit-animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            }
        </style>
    </head>
    <body class="font-sans bg-gray-900 text-white">
        <div class="min-h-screen">
            @include('layouts.navigation')
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>
        <footer class="border border-t border-gray-800">
            <div class="container mx-auto text-sm px-4 py-6">
                Powered by <a href="https://www.themoviedb.org/documentation/api" class="underline hover:text-gray-300">TMDb API</a>
            </div>
        </footer>
        <livewire:scripts />
        @yield('scripts')
    </body>

</html>
