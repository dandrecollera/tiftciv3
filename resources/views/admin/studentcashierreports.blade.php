@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Transaction Reports</h1>
        </div>
    </div>
    <button type="button" id="generatebuttopn" class="btn btn-dark shadow-sm btn-sm" data-bs-toggle="modal"
        data-bs-target="#addeditmodal">Generate Report</button>
    <hr>
    <div class="row" ">
        <div class=" col-md-6">
        <canvas id="dailyChart" width="400" height="200"></canvas>
    </div>

    <div class="col-md-6">
        <canvas id="weeklyChart" width="400" height="200"></canvas>
    </div>
</div>

<div class="row">
    <div class="col overflow-scroll scrollable-container mb-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><strong>ID</strong></th>
                    <th scope="col"><strong>User</strong></th>
                    <th scope="col"><strong>Amount</strong></th>
                    <th scope="col"><strong>Type</strong></th>
                    <th scope="col"><strong>Date</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dbresult as $dbr)
                <tr>
                    <td>{{$dbr->id}}</td>
                    <td>
                        @php
                        $username = DB::table('main_users_details')
                        ->where('userid', $dbr->userid)
                        ->first();
                        @endphp
                        {{$username->firstname}} {{$username->middlename}} {{$username->lastname}}
                    </td>
                    <td>{{$dbr->amount}}</td>
                    <td>
                        {{$dbr->voucher == 1 ? 'Voucher ' : ''}}
                        {{$dbr->tuition == 1 ? 'Tuition ' : ''}}
                        {{$dbr->registration == 1 ? 'Registration ' : ''}}
                    </td>
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


<div class="modal fade" id="addeditmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addeditmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <div>Generate Report</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Create Reports</h4>
                <div class="input-group mb-4">
                    <div class="form-outline">
                        <input type="date" class="form-control" name="startdate" id="startdate">
                        <label class="form-label" for="startdate">Start Date</label>
                    </div>
                    <div class="form-outline">
                        <input type="date" class="form-control" name="enddate" id="enddate">
                        <label class="form-label overflow-x-scroll pe-2" for="enddate">End Date</label>
                    </div>
                </div>
                <a href="" class="btn btn-black float-end" id="generatebutton" target="_blank">Generate</a>
            </div>


        </div>
    </div>
</div>


@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function () {


    $('#startdate, #enddate').on('change', function(){
        $('#generatebutton').attr('href', '/cashreport?start=' + $('#startdate').val() + '&end=' + $('#enddate').val());
    })
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