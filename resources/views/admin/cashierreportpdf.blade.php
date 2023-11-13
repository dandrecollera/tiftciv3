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
        <p style="font-size: 23px">Trent Information First Technical Career Institute Inc.</p>
        <hr>
    </center>

    <p><span style="font-size: 20px">Transaction Reports</span><br>{{ \Carbon\Carbon::parse($start)->format('F j, Y') }}
        - {{ \Carbon\Carbon::parse($end)->format('F j, Y') }}</p>

    <table class="table">
        <tbody>
            <tr>
                <td>Total Amount</td>
                <td>{{$dailyData[0]->total_amount}}</td>
            </tr>
        </tbody>
        </thead>
    </table>
    <p>List of Transactions</p>
    <table class="table">
        <thead>
            <tr>
                <th><strong>ID</strong></th>
                <th><strong>Student</strong></th>
                <th><strong>Amount</strong></th>
                <th><strong>Type</strong></th>
                <th><strong>Date</strong></th>
            </tr>
        <tbody>
            @foreach ($selected as $sel)

            <tr>
                <td>{{$sel->id}}</td>
                <td>
                    @php
                    $username = DB::table('main_users_details')
                    ->where('userid', $sel->userid)
                    ->first();
                    @endphp
                    {{$username->firstname}} {{$username->middlename}} {{$username->lastname}}
                </td>
                <td>{{$sel->amount}}</td>
                <td>
                    {{$sel->voucher == 1 ? 'Voucher ' : ''}}
                    {{$sel->tuition == 1 ? 'Tuition ' : ''}}
                    {{$sel->registration == 1 ? 'Registration ' : ''}}
                </td>
                <td>{{$sel->created_at}}</td>

            </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
</body>

</html>