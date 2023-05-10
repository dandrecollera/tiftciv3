<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>

    <link rel="stylesheet" href="{{ asset('css/sidenavtop.css')}}">
    <link rel="stylesheet" href="{{ asset('css/mdb.min.css')}}">

</head>

<body>

    <form action="/login" method="post">
        @csrf
        <img src="{{asset('asset/tiflogo.png')}}" height="100" alt="" />
        @isset($err)
        <div class="sumb-alert alert alert-{{ !empty($errors[$err][1]) ? $errors[$err][1] : 'alert' }}" role="alert">
            {{ !empty($errors[$err][0]) ? $errors[$err][0] : 'error' }}
        </div>
        @endisset
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Log in</button>
    </form>

    .div


</body>

</html>