<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('css/mdb.min.css')}}">

    <title>Document</title>

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

        input[type="email"],
        input[type="password"],
        button[type="submit"] {
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 300px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
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
                        <input type="email" name="email" placeholder="Email">
                        <input type="password" name="password" placeholder="Password">
                        <button type="submit">Log in</button>
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

</body>

</html>