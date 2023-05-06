@extends('student.components.layout')

@section('content')
<div class="row py-3">
    <div class="col-lg-8 mb-3">
        <div class="col  mb-2">

            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title">Balance</h5>
                    <h6 class="card-title">{{ $balance->school_year}}</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Fees</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Voucher</th>
                                <td></td>
                                <td></td>
                                <td>{{ $balance->voucher}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tuition</th>
                                <td></td>
                                <td></td>
                                <td>{{ $balance->tuition}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Registration</th>
                                <td></td>
                                <td></td>
                                <td>{{ $balance->registration}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total</th>
                                <td></td>
                                <td></td>
                                <td>{{ $total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title">{{$studentsection->section_name}} Schedule</h5>
                    <h6 class="card-title">{{$today}}</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Subject</th>
                                <th scope="col">Start</th>
                                <th scope="col">End</th>
                                <th scope="col">Teacher</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                            <tr>
                                <th scope="row">{{ $schedule->subject_name }}</th>
                                <td>{{ $schedule->start_time }}</td>
                                <td>{{ $schedule->end_time }}</td>
                                <td>{{$schedule->firstname}} {{$schedule->middlename}} {{$schedule->lastname}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Latest News</h6>
                <h6 class="card-title">No Recent News</h6>
            </div>
        </div>
    </div>
</div>
@endsection