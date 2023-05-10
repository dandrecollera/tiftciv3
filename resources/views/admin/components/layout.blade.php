<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', env('WEB_TITLE'))</title>

    {{--
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('css/sidenavtop.css')}}">
    <link rel="stylesheet" href="{{ asset('css/mdb.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/fontawesome.min.css"
        integrity="sha512-cHxvm20nkjOUySu7jdwiUxgGy11vuVPE9YeK89geLMLMMEOcKFyS2i+8wo0FOwyQO/bL8Bvq1KMsqK4bbOsPnA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/brands.min.css"
        integrity="sha512-L+sMmtHht2t5phORf0xXFdTC0rSlML1XcraLTrABli/0MMMylsJi3XA23ReVQkZ7jLkOEIMicWGItyK4CAt2Xw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="icon" type="image/ico" href="{{ asset('favicon/favicon.ico') }}">
    <style>
        * {
            scrollbar-width: auto;
            scrollbar-color: rgba(0, 0, 0, 0.2) rgba(0, 0, 0, 0.2);
            transition: .1s;
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

        .list-group-item-spec {
            background-color: #3b3737;
            color: white;
        }

        .newsclass {
            color: white;
            transition: .2s;
        }

        .newsclass:hover {
            color: rgb(180, 180, 180);
            transition: .2s;
        }
    </style>

</head>

<body style="background-image: url('/asset/polka2.png')">
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse list-group-item-spec">

            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">

                    @include('admin.components.sidemenu')

                    <div class="dropdown py-2 mx-2 mt-2 d-block d-lg-none">
                        <a href="#"
                            class="nav-link dropdown-toggle hidden-arrow text-white text-small d-flex align-items-center"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @include('admin.components.imagename')
                        </a>
                        <ul class="dropdown-menu text-small shadow dropdown-menu-start">
                            @include('admin.components.usermenu')
                        </ul>
                    </div>

                </div>
            </div>

        </nav>
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid ">
                <a class="navbar-brand fw-bolder ps-2 text-white" href="/admin">
                    <img src="{{asset('asset/tiflogo.png')}}" height="60" alt="" />Admin
                </a>
                <!-- Right links -->

                <div class="btn-group shadow-0 d-none d-lg-block">
                    <a class="dropdown-toggle hidden-arrow pe-3" type="button" id="dropdownMenuButton"
                        data-mdb-toggle="dropdown">
                        @include('admin.components.imagename')
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @include('admin.components.usermenu')
                    </ul>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <i class="fas fa-bars" style="color:white;"></i>
                </button>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>


    <main style="margin-top: 90px">
        <div class="container pt-2 pt-lg-4">
            @yield('content')
        </div>
    </main>

    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('js/mdb.min.js')}}"></script>

    @stack('jsscripts')

</body>

</html>