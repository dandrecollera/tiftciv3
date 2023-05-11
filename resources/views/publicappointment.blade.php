<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', env('WEB_TITLE'))</title>

    {{--
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}"> --}}
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
    </style>

</head>

<body style="background-image: url('/asset/polka2.png')">
    <header>


        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid ">
                <a class="navbar-brand fw-bolder ps-2 text-white" href="https://dandrecollera.com/">
                    <img src="{{asset('asset/tiflogo.png')}}" height="60" alt="" /> <span style="line-height:1.2">Alumni
                        Document<br>Request</span>
                </a>
                <!-- Right links -->

                <div class="btn-group shadow-0 d-none d-lg-block">
                    <a class="dropdown-toggle hidden-arrow pe-3" type="button" id="dropdownMenuButton"
                        data-mdb-toggle="dropdown">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    </ul>
                </div>

            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>


    <main style="margin-top: 90px">
        @if (!empty($error))
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error</h4>
                    <p>{{ $errorlist[(int) $error ] }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif
        @if (!empty($notif))
        <div class="row">
            <div class="col">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success</h4>
                    <p>{{ $notiflist[(int) $notif ] }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif
        <div class="container pt-2 pt-lg-4">
            <div class="row">
                <div class="col-12">
                    <iframe src="appointment_add" frameborder="0" width="100%" style="height:130vh;"></iframe>

                </div>
            </div>
        </div>
    </main>

    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('js/mdb.min.js')}}"></script>

    @stack('jsscripts')

</body>

</html>