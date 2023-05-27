<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" href="https://itc.edu.kh/wp-content/uploads/2021/02/logoitc.png" />

    <!-- Fonts -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="http://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/js/app.js') }}" defer></script>
    <script src="{{ asset('/js/bootstrap.js') }}" defer></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('/js/jquery-3.7.0.min.js') }}" defer></script>
    <style>
        body {
            background: #e4e9f7;
        }
    </style>
</head>

<body>
    <div class="sidebar close">
        <div class="mt-2 pt-1 d-flex justify-content-center align-item-center">
            <img style="width: 2.2rem; margin: none;" src="https://itc.edu.kh/wp-content/uploads/2021/02/logoitc.png"
                alt="">
        </div>
        <ul class="nav-links ">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="/dashboard">
                    <i class='bx bxs-dashboard'></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/dashboard">Dashboard</a></li>
                </ul>
            </li>
            <li class="{{ request()->is('categories') ? 'active' : '' }}">
                <a href="/categories">
                    <i class='bx bx-category'></i>
                    <span class="link_name">Categories</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/categories">Category</a></li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('items.*') ? 'active' : '' }}">
                <a href="/items">
                    <i class='bx bxs-folder-minus'></i>
                    <span class="link_name">Items</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/items">Items</a></li>
                </ul>
            </li>
            <li class="{{ request()->is('transactions') ? 'active' : '' }}">
                <a href="/transactions">
                    <i class='bx bx-transfer'></i>
                    <span class="link_name">Transactions</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/transactions">Transactions</a></li>
                </ul>
            </li>
            {{-- add new --}}
            <!-- <li class="{{ request()->is('depaments') ? 'active' : '' }}">
                <a href="/buildings">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Departments</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/buildings">Departments</a></li>
                </ul>
            </li> -->
            {{--  --}}
            <li class="{{ request()->is('buildings') ? 'active' : '' }}">
                <a href="/buildings">
                    <i class='bx bx-building'></i>
                    <span class="link_name">Buildings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/buildings">Buildings</a></li>
                </ul>
            </li>
            <li class="{{ request()->is('rooms') ? 'active' : '' }}">
                <a href="/rooms">
                    <i class='bx bx-building-house'></i>
                    <span class="link_name">Rooms</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/buildings">Rooms</a></li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <a href="/employees">
                    <i class='bx bx-user-plus'></i>
                    <span class="link_name">Employee</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/employees">Employee</a></li>
                </ul>
            </li>
            <li class="{{ request()->is('sponsor') ? 'active' : '' }}">
                <a href="/sponsor">
                    <i class='bx bxs-user-account'></i>
                    <span class="link_name">Sponsor</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/sponsor">Sponsor</a></li>
                </ul>
            </li>
            <li class="{{ request()->is('status') ? 'active' : '' }}">
                <a href="/status">
                    <i class='bx bxs-star-half'></i>
                    <span class="link_name">Status</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/status">Status</a></li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('setting.*') ? 'active' : '' }}">
                <a href="/setting">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">Setting</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/setting"><i class='bx bx-cog'></i> Setting</a></li>
                    <li><a class="link_name" href="/buildings"><i class='bx bx-building'></i> Buildings</a></li>
                    <li><a class="link_name" href="/employees"><i class="bx bx-user-plus"></i> Employees</a></li>
                    <li><a class="link_name" href="/status"><i class='bx bxs-star-half'></i> Status</a></li>

                </ul>
            </li>
            <li style="position: absolute; bottom:0% ; margin-bottom: 10px; width: calc(100% - 1px);">
                <div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                      document.getElementById('frm-logout').submit();">
                        <i style="font-size: 20px;" class="bx bx-log-out"></i>
                        <span class="link_name">Logout</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                      document.getElementById('frm-logout').submit();">Logout</a>
                        </li>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="home-section">
        <div class="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-0">
                <div class="home-content">
                    <i class="bx bx-menu"></i>
                    <span class="text">Inventory Management </span>
                </div>
                <div class="me-3 collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <!-- <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a> -->
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link " href="/setting">
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>
        <div style="background: #e4e9f7;" class="mx-3 rounded">
            @yield('content')
        </div>
    </div>
    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
        let table = new DataTable('#myTable');
    </script>
</body>

</html>
