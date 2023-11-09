@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Transaction Reports</h1>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <canvas id="dailyAppointmentsChart" width="400" height="200"></canvas>
        </div>

        <div class="col-md-6">
            <canvas id="weeklyAppointmentsChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col overflow-scroll scrollable-container mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><strong>ID</strong></th>
                        <th scope="col"><strong>Document</strong></th>
                        <th scope="col"><strong>Date</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr>
                        <td>{{$dbr->id}}</td>
                        <td>{{$dbr->goodmoral == '1' ? 'Good Moral, ' : ''}} {{$dbr->registration == '1' ?
                            'Registration, '
                            : ''}}
                            {{$dbr->f138 == '1' ? 'F138, ' : ''}}
                            @if ($dbr->others == '1')
                            {{$dbr->otherreason}}
                            @endif
                        </td>
                        {{-- <td>{{$dbr->goodmoral}}</td> --}}
                        <td>{{$dbr->updated_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="input-group mb-4">
            {!!$page_first_url!!}
            {!!$page_prev_url!!}
            <span class="input-group-text bg-dark text-white w-auto" id="basic-addon3">{{$page}}/{{$totalpages}}</span>
            {!!$page_next_url!!}
            {!!$page_last_url!!}
        </div>
    </div>
</div>





@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function () {
    // Fetch daily data from Laravel route
    $.get('/getDailyAppointmentsCount', function (dailyCounts) {
        // Process data for daily Chart.js
        var dailyLabels = [];
        var goodmoralCounts = [];
        var registrationCounts = [];
        var f138Counts = [];
        var othersCounts = [];

        dailyCounts.forEach(function (entry) {
            dailyLabels.push(entry.date);
            goodmoralCounts.push(entry.goodmoral_count);
            registrationCounts.push(entry.registration_count);
            f138Counts.push(entry.f138_count);
            othersCounts.push(entry.others_count);
        });

        // Create a daily bar chart for appointments
        var dailyAppointmentsCtx = document.getElementById('dailyAppointmentsChart').getContext('2d');
        var dailyAppointmentsChart = new Chart(dailyAppointmentsCtx, {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [
                    {
                        label: 'Good Moral',
                        data: goodmoralCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Registration',
                        data: registrationCounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'F138',
                        data: f138Counts,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Others',
                        data: othersCounts,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    // Fetch weekly data from Laravel route
    $.get('/getWeeklyAppointmentsCount', function (weeklyCounts) {
        // Process data for weekly Chart.js
        var weeklyLabels = [];
        var goodmoralCounts = [];
        var registrationCounts = [];
        var f138Counts = [];
        var othersCounts = [];

        weeklyCounts.forEach(function (entry) {
            // Assuming you want to display the week number along with the year
            var weekLabel = entry.year + '-W' + entry.week;
            weeklyLabels.push(weekLabel);
            goodmoralCounts.push(entry.goodmoral_count);
            registrationCounts.push(entry.registration_count);
            f138Counts.push(entry.f138_count);
            othersCounts.push(entry.others_count);
        });

        // Create a weekly bar chart for appointments
        var weeklyAppointmentsCtx = document.getElementById('weeklyAppointmentsChart').getContext('2d');
        var weeklyAppointmentsChart = new Chart(weeklyAppointmentsCtx, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [
                    {
                        label: 'Good Moral',
                        data: goodmoralCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Registration',
                        data: registrationCounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'F138',
                        data: f138Counts,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Others',
                        data: othersCounts,
                        backgroundColor: 'rgba(153,102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
});
</script>

@endpush