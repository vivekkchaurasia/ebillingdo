<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        #sidebarMenu {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        main {
            background-color: #f1f1f1;
            min-height: 100vh;
        }
        footer {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item mb-2 mt-2">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item mb-2 mt-2">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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

        <div class="container-fluid">
            <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column mt-3 mb-2">
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('invoices.index') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                                <span data-feather="file"></span>
                                Invoice
                            </a>
                        </li>
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('stock.report') ? 'active' : '' }}" aria-current="page" href="{{ route('stock.report') }}">
                                <span data-feather="home"></span>
                                Stock Report
                            </a>
                        </li>
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('stock-purchases.index') ? 'active' : '' }}" href="{{ route('stock-purchases.index') }}">
                                <span data-feather="shopping-cart"></span>
                                Stock Purchases
                            </a>
                        </li>
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('items.index') ? 'active' : '' }}" href="{{ route('items.index') }}">
                                <span data-feather="users"></span>
                                Item
                            </a>
                        </li>
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('item-categories.index') ? 'active' : '' }}" href="{{ route('item-categories.index') }}">
                                <span data-feather="bar-chart-2"></span>
                                Item Categories
                            </a>
                        </li>
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <span data-feather="layers"></span>
                                Users
                            </a>
                        </li>
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('user-roles.index') ? 'active' : '' }}" href="{{ route('user-roles.index') }}">
                                <span data-feather="layers"></span>
                                Roles
                            </a>
                        </li>
                        <li class="nav-item mb-2 mt-2">
                            <a class="nav-link {{ request()->routeIs('user-permissions.index') ? 'active' : '' }}" href="{{ route('user-permissions.index') }}">
                                <span data-feather="layers"></span>
                                Permissions
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>


                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mb-5">
                    @yield('content')
                </main>
            </div>
        </div>

        <footer class="mt-5">
            &copy; {{ date('Y') }} Powered by <a href="https://vhforge.com" class="link-warning" target="_blank">VHForge</a> All Rights Reserved.
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>
</body>
</html>
