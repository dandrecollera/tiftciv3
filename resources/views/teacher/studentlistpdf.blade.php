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
            background-color: #7ab4f7;
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

    <p><span style="font-size: 20px">{{ $section->name }} Students List</span><br>School Year: {{$section->schoolyear}}
        || Semester: {{$section->semester}} || Year Level: {{$section->yearlevel}}
    </p>

    <table class="table">
        <thead>
            <tr>
                <th><strong>Email</strong></th>
                <th><strong>LRN</strong></th>
                <th><strong>Name</strong></th>
                <th><strong>Contact No.</strong></th>
                <th colspan="4"><strong>Address</strong></th>
            </tr>
        <tbody>
            @foreach ($dbresult as $dbr)
            <tr>
                <td><strong>{{$dbr->email}}</strong></td>
                <td><strong>{{$dbr->lrn}}</strong></td>
                <td><strong>{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}</strong></td>
                <td><strong>{{$dbr->mobilenumber}}</strong></td>
                <td colspan="4"><strong>{{$dbr->address}}</strong></td>
            </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
</body>

</html>