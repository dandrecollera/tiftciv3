@extends('teacher.components.layout')

@section('content')
<div class="row py-3">
    <div class="col-lg-8 mb-3">
        <div class="col  mb-2">
            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title"><strong>Today: {{$today}}</strong></h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><strong>Section</strong></th>
                                <th scope="col"><strong>Start</strong></th>
                                <th scope="col"><strong>End</strong></th>
                                <th scope="col"><strong>Subject</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                            <tr>
                                <th scope="row"><strong>{{ $schedule->section_name }}</strong></th>
                                <td>{{ $schedule->start_time }}</td>
                                <td>{{ $schedule->end_time }}</td>
                                <td>{{ $schedule->subject_name }}</td>
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