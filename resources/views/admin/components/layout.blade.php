<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', env('WEB_TITLE'))</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/sidenavtop.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/fontawesome.min.css"
        integrity="sha512-cHxvm20nkjOUySu7jdwiUxgGy11vuVPE9YeK89geLMLMMEOcKFyS2i+8wo0FOwyQO/bL8Bvq1KMsqK4bbOsPnA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/brands.min.css"
        integrity="sha512-L+sMmtHht2t5phORf0xXFdTC0rSlML1XcraLTrABli/0MMMylsJi3XA23ReVQkZ7jLkOEIMicWGItyK4CAt2Xw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        * {
            scrollbar-width: auto;
            scrollbar-color: rgba(0, 0, 0, 0.2) rgba(0, 0, 0, 0.2);
        }

        /* Chrome, Edge, and Safari */
        ::-webkit-scrollbar {
            width: 2px;
            height: 2px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.0);
        }

        .dpcover {
            object-fit: cover;
        }
    </style>

</head>

<body style="background-image: url('/asset/polka2.png')">
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">

            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-0 mt-lg-3">

                    @include('admin.components.sidemenu')

                    <div class="dropdown py-2 mx-2 mt-2 d-block d-lg-none">
                        <a href="#" class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @include('admin.components.imagename')
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            @include('admin.components.usermenu')
                        </ul>
                    </div>

                </div>
            </div>

        </nav>
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <a class="navbar-brand fw-bolder" href="#">
                    {{-- <img src="" height="25" alt="" /> --}}
                    TIFTCI Admin
                </a>
                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row d-none d-lg-block">
                    <!-- Avatar -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                            id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @include('admin.components.imagename')
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-label="navbarDropdownMenuLink">
                            @include('admin.components.usermenu')
                        </ul>
                    </li>
                </ul>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>


    <main style="margin-top: 72px">
        <div class="container pt-2 pt-lg-4">
            @yield('content')
        </div>
    </main>

    <script src="{{asset('js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>

    @stack('jsscripts')

</body>

</html>