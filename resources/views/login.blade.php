<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
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

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
</head>

<body>
    @isset($err)
    <div class="sumb-alert alert alert-{{ !empty($errors[$err][1]) ? $errors[$err][1] : 'alert' }}" role="alert">
        {{ !empty($errors[$err][0]) ? $errors[$err][0] : 'error' }}
    </div>
    @endisset
    <form action="/login" method="post">
        @csrf
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Log in</button>
    </form>
</body>

</html>