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

    <p><span style="font-size: 20px">{{$userinfo[1]}} {{$userinfo[2]}} {{$userinfo[3]}}'s Schedule</span><br>School
        Year:
        {{$selectedyear}} </p>

    <table class="table">
        <thead>
            <tr>
                <th><strong></strong></th>
                <th><strong>Section</strong></th>
                <th><strong>Start Time</strong></th>
                <th><strong>End Time</strong></th>
                <th><strong>Day</strong></th>
                <th><strong>Subject</strong></th>
            </tr>
        <tbody>
            @php
            $count = 1;
            @endphp
            @foreach ($teacherschedule as $schedule)

            <tr>
                <td scope="row"><strong>{{$count}}</strong></td>
                <td scope="row"><strong>{{$schedule['section']}}</strong></td>
                <td>{{$schedule['startTime']}}</td>
                <td>{{$schedule['endTime']}}</td>
                <td>{{$schedule['day']}}</td>
                <td>{{$schedule['subject']}}</td>
            </tr>
            @php
            $count++;
            @endphp
            @endforeach
        </tbody>
        </thead>
    </table>
</body>

</html>