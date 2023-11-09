@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Transaction Reports</h1>
        </div>
    </div>
    <hr>
    <div class="row" ">
        <div class=" col-md-6">
        <canvas id="dailyChart" width="400" height="300"></canvas>
    </div>

    <div class="col-md-6">
        <canvas id="weeklyChart" width="400" height="300"></canvas>
    </div>
</div>

<div class="row">
    <div class="col overflow-scroll scrollable-container mb-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><strong>ID</strong></th>
                    <th scope="col"><strong>Amount</strong></th>
                    <th scope="col"><strong>Date</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dbresult as $dbr)
                <tr>
                    <td>{{$dbr->id}}</td>
                    <td>{{$dbr->amount}}</td>
                    <td>{{$dbr->created_at}}</td>
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
    $.get('/getDailyChartData', function (dailyData) {
        // Process data for daily Chart.js
        var dailyLabels = [];
        var dailyAmounts = [];

        dailyData.forEach(function (entry) {
            dailyLabels.push(entry.date);
            dailyAmounts.push(entry.total_amount);
        });

        // Create a daily bar chart
        var dailyCtx = document.getElementById('dailyChart').getContext('2d');
        var dailyChart = new Chart(dailyCtx, {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Total Amount',
                    data: dailyAmounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
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
    $.get('/getWeeklyChartData', function (weeklyData) {
        // Process data for weekly Chart.js
        var weeklyLabels = [];
        var weeklyAmounts = [];

        weeklyData.forEach(function (entry) {
            // Assuming you want to display the week number along with the year
            var weekLabel = entry.year + '-W' + entry.week;
            weeklyLabels.push(weekLabel);
            weeklyAmounts.push(entry.total_amount);
        });

        // Create a weekly bar chart
        var weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        var weeklyChart = new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Total Amount',
                    data: weeklyAmounts,
                    backgroundColor: 'rgba(192, 75, 192, 0.2)',
                    borderColor: 'rgba(192, 75, 192, 1)',
                    borderWidth: 1
                }]
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