<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EZTAX') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @include('layouts.css')
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'EZTAX') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <style>
                        .hover-effect:hover {
                            background-color: #e9ecef;
                            /* Bootstrap primary */
                            color: black !important;
                        }
                    </style>
                    <ul class="navbar-nav me-auto">
                        @if(auth()->check())
                            @if(auth()->user()->is_admin == 1)
                                <li class="nav-item">
                                    <a href="{{ route('users') }}" 
                                    class=" align-items-center py-2 px-3 text-decoration-none rounded
                                    {{ request()->is('users*') ? 'active' : 'text-secondary' }} 
                                    hover-effect">
                                        <span>User</span>
                                    </a>
                                </li>
                                @else
                            
                                <li class="nav-item">
                                    <a href="{{ route('clients') }}" class=" align-items-center py-2 px-3 text-decoration-none rounded
                                    {{ request()->is('clients*') ? 'active' : 'text-secondary' }} 
                                    hover-effect">
                                        <i class="bi bi-people"> </i><span>Clients</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('notices') }}" class=" align-items-center py-2 px-3 text-decoration-none rounded
                                    {{ request()->is('notices*') ? 'active' : 'text-secondary' }} 
                                    hover-effect">
                                        <i class="bi bi-file-earmark-medical"> </i><span>Notices</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('calculator') }}" class=" align-items-center py-2 px-3 text-decoration-none rounded
                                    {{ request()->is('calculator*') ? 'active' : 'text-secondary' }} 
                                    hover-effect">
                                        <i class="bi bi-calculator"> </i><span>Tax Calculator</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('file.manager') }}" class="align-items-center py-2 px-3 text-decoration-none rounded
                                    {{ request()->is('file-manager*') ? 'active' : 'text-secondary' }} 
                                    hover-effect">
                                        <i class="bi bi-database"> </i><span>File Manager</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('layouts.js')

    <script>
        @if(Session::has('success'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
</body>

</html>