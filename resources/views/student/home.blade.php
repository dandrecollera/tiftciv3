@extends('student.components.layout')

@section('content')
<div class="row py-3">
    <div class="col-lg-8 mb-3">
        <div class="col mb-2">

            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title">{{$sectname->name}} Schedule</h5>
                    <h6 class="card-title">{{$today}}</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><strong>Subject</strong></th>
                                <th scope="col"><strong>Start</strong></th>
                                <th scope="col"><strong>End</strong></th>
                                <th scope="col"><strong>Teacher</strong></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($newsched as $schedule)
                            <tr>


                                <th scope="row"><strong>{{ $schedule['subject'] }}</strong></th>
                                <th scope="row"><strong>{{ $schedule['startTime'] }}</strong></th>
                                <th scope="row"><strong>{{ $schedule['endTime'] }}</strong></th>
                                <th scope="row"><strong>{{ $schedule['teacher']->firstname }} {{
                                        $schedule['teacher']->middlename }} {{ $schedule['teacher']->lastname
                                        }}</strong>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title"><strong>Balance</strong></h5>
                    <h6 class="card-title">{{ $balance->schoolyear}}</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><strong>Fees</strong></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"><strong>Price</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><strong>Voucher</strong></th>
                                <td></td>
                                <td></td>
                                <td>₱{{ number_format($balance->voucher, 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Tuition</strong></th>
                                <td></td>
                                <td></td>
                                <td>₱{{ number_format($balance->tuition, 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Registration</strong></th>
                                <td></td>
                                <td></td>
                                <td>₱{{ number_format($balance->registration, 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Total</strong></th>
                                <td></td>
                                <td></td>
                                <td>₱{{ number_format($total, 2, '.', ',') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <h4 class="card-header">Latest News</h4>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($news as $nw)
                    <li class="list-group-item" aria-current="true">
                        <a href="https://tiftci.org/news/{{$nw->post_name}}" class="newsclass"
                            target="_blank">{{$nw->post_title}}</a><br>
                        <span style="font-size:10px">{{ date('m/d/Y g:iA', strtotime($nw->post_modified)) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection