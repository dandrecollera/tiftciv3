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
    <main style="margin-top: 90px">
        <div class="container pt-2 pt-lg-4">
            <div class="row">
                <div class="col-12">
                    <h1>Hello {{ $user }}, </h1>


                    <p>
                        @if ( $status == 'Pending')
                        Please wait for further announcement regarding with your request <strong>{{ $request }}</strong>
                        @endif
                        @if ( $status == 'Approved')
                        Your request: <strong>{{ $request }}</strong> is now approved, please come to TIFTCI on {{
                        date('m/d/Y l', strtotime($date)) }}
                        @endif
                        @if ( $status == 'Completed')
                        Thank you for trusting TIFTCI, visit <a href="https://tiftci.org/">https://tiftci.org/</a> for
                        more info about us!
                        @endif
                        @if ( $status == 'Declined')
                        Your request: <strong>{{ $request }}</strong> is declined, you can try to make a new appointment
                        in your student portal or if you're not enrolled currently, you can visit this <a
                            href="https://tiftci.org/appointment">Link</a>
                        @endif
                        @if ( $status == 'Cancelled')
                        you have cancelled your request: <strong>{{ $request }}</strong>
                        @endif

                        <br><br>
                        TIFTCI Support
                    </p>

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