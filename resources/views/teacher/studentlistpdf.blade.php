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

        tr th {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <h1>
        {{ $section->name }} Students
    </h1>
    <p>School Year: {{$section->schoolyear}} || Semester: {{$section->semester}} || Year Level: {{$section->yearlevel}}
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
                <th><strong>{{$dbr->email}}</strong></th>
                <th><strong>{{$dbr->lrn}}</strong></th>
                <th><strong>{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}</strong></th>
                <th><strong>{{$dbr->mobilenumber}}</strong></th>
                <th colspan="4"><strong>{{$dbr->address}}</strong></th>
            </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
</body>

</html>
