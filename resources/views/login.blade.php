<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('css/mdb.min.css')}}">
    <link rel="icon" type="image/ico" href="{{ asset('favicon/favicon.ico') }}">
    <title>TIFTCI</title>

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
        video {
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 90vh;
        }
    </style>

</head>

<body style="background-image: url('/asset/polka2.png')">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 p-0 bg-white loginz" style=" z-index: 4; background-image: url('/asset/polka2.png')">
                <div class=" p-5" style="height:100vh;">
                    <form action="/login" method="post">
                        @csrf
                        <img src="{{asset('asset/tiflogo.png')}}" height="100" alt="" />
                        @isset($err)
                        <div class="sumb-alert alert alert-{{ !empty($errors[$err][1]) ? $errors[$err][1] : 'alert' }}"
                            role="alert">
                            {{ !empty($errors[$err][0]) ? $errors[$err][0] : 'error' }}
                        </div>
                        @endisset

                        <div class="form-outline mt-2 mb-3" style="width:300px">
                            <input type="email" id="email" class="form-control" name="email" />
                            <label class="form-label" for="form12">Email</label>
                        </div>
                        <div class="form-outline mb-3" style="width:300px">
                            <a id="show1" href="#" style="color: inherit;"><i class="fas fa-eye-slash trailing pe-auto"
                                    id="eye1"></i></a>
                            <input type="password" id="password" class="form-control" name="password" required />
                            <label class="form-label" for="form12">Password</label>
                        </div>




                        <button type="submit" class="btn btn-warning">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-lg-block d-none p-0 overflow-hidden"
                style="height:100vh; box-shadow: inset 22px 0px 16px rgba(0, 0, 0, 0.32);">
                <video autoplay muted loop style="z-index: -2;">
                    <source src="{{ asset('asset/TIF-1_Trim.mp4')}}" type="video/mp4" />
                </video>
                <div style="position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: 0;
                background: linear-gradient(0deg, rgba(251, 133, 0, 0.28), rgba(251, 133, 0, 0.28))">
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{asset('js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('js/mdb.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

        $('#show1').on('click', function() {
            if($('#password').attr('type') == "text"){
                $('#password').attr('type', 'password');
                $('#eye1').addClass( "fa-eye-slash" );
                $('#eye1').removeClass( "fa-eye" );
            } else{
                $('#password').attr('type', 'text');
                $('#eye1').addClass( "fa-eye" );
                $('#eye1').removeClass( "fa-eye-slash" );
            }
        });
        $('#show2').on('click', function() {
            if($('#password2').attr('type') == "text"){
                $('#password2').attr('type', 'password');
                $('#eye2').addClass( "fa-eye-slash" );
                $('#eye2').removeClass( "fa-eye" );
            } else{
                $('#password2').attr('type', 'text');
                $('#eye2').addClass( "fa-eye" );
                $('#eye2').removeClass( "fa-eye-slash" );
            }
        });
    });
    </script>
</body>

</html>