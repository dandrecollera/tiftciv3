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
        Schedule
    </h1>
    <p>School Year: {{$selectedyear}}
    </p>

    <table class="table">
        <thead>
            <tr>
                <th><strong>Section</strong></th>
                <th><strong>Start Time</strong></th>
                <th><strong>End Time</strong></th>
                <th><strong>Day</strong></th>
                <th colspan="4"><strong>Subject</strong></th>
            </tr>
        <tbody>
            @foreach ($teacherschedule as $schedule)

            <tr>
                <th scope="row"><strong>{{$schedule['section']}}</strong></th>
                <td>{{$schedule['startTime']}}</td>
                <td>{{$schedule['endTime']}}</td>
                <td>{{$schedule['day']}}</td>
                <td>{{$schedule['subject']}}</td>
            </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
</body>

</html>
