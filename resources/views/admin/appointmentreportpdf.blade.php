<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student List</title>
    {{-- <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
    --}}

    <link rel="stylesheet" href="{{ asset('css/sidenavtop.css')}}">
    <link rel="stylesheet" href="{{ asset('css/mdb.min.css')}}">

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid;
            font-size: 10px;
        }

        th {
            background-color: #ffc32c;
            color: rgb(7, 7, 7);
            border: 1px solid;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <center>
        <img src="{{asset('asset/tiflogo.png')}}" alt="" style="max-width: 25%"><br>
        <p>Trent Information First Technical Career Institute Inc.</p>
        <hr>
    </center>

    <p><span style="font-size: 20px">Appointment Reports</span><br>{{ \Carbon\Carbon::parse($start)->format('F j, Y') }}
        - {{ \Carbon\Carbon::parse($end)->format('F j, Y') }}</p>

    <p>Number of Released Documents</p>
    <table class="table">
        <thead>
            <tr>
                <th><strong>Document Type</strong></th>
                <th><strong>Count</strong></th>

            </tr>
        <tbody>
            <tr>
                <td>Good Moral</td>
                <td>{{$goodmoral}}</td>
            </tr>
            <tr>
                <td>Registration</td>
                <td>{{$registration}}</td>
            </tr>
            <tr>
                <td>F138</td>
                <td>{{$f138}}</td>
            </tr>
            <tr>
                <td>Others</td>
                <td>{{$others}}</td>
            </tr>
        </tbody>
        </thead>
    </table>
    <hr>
    <p>Documents Released</p>
    <table class="table">
        <thead>
            <tr>
                <th><strong>ID</strong></th>
                <th><strong>Document</strong></th>
                <th><strong>Date</strong></th>
            </tr>
        <tbody>
            @foreach ($selected as $sel)

            <tr>
                <td scope="row">{{$sel->id}}</td>
                <td>{{$sel->goodmoral == '1' ? 'Good Moral, ' : ''}} {{$sel->registration == '1' ?
                    'Registration, '
                    : ''}}
                    {{$sel->f138 == '1' ? 'F138, ' : ''}}
                    @if ($sel->others == '1')
                    {{$sel->otherreason}}
                    @endif
                </td>
                <td>{{$sel->appointeddate}}</td>
            </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
</body>

</html>