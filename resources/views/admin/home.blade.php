@extends('admin.components.layout')

@section('content')

@php
$latestappointments = DB::table('appointments')
->orderBy('id', 'desc')
->limit(4)
->get()
->toArray();
@endphp

<div class="container-xl mt-4">
    <h1>
        <strong>Dashboard</strong>
    </h1>
    <div class="row py-3">
        <div class="col-12 col-sm-4 mb-sm-0 mb-3">
            <div class="card text-center text-bg-dark    ">
                <div class="card-body">
                    <h6 class="card-title">Number of Students</h6>
                    <h3 class="card-title">{{$studentcount}}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 mb-sm-0 mb-3">
            <div class="card text-center text-bg-dark">
                <div class="card-body">
                    <h6 class="card-title">Number of Teachers</h6>
                    <h3 class="card-title">{{$teachercount}}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 mb-sm-0 mb-3">
            <div class="card text-center text-bg-dark">
                <div class="card-body">
                    <h6 class="card-title">Number of Admins</h6>
                    <h3 class="card-title">{{$admincount}}</h3>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row py-3">
        <div class="col-lg-4 order-lg-last mb-3">
            <div class="card text-bg-dark">
                <h4 class="card-header"><strong>Latest News</strong></h4>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($news as $nw)
                        <li class="list-group-item list-group-item-dark" aria-current="true">
                            <a href="https://dandrecollera.com/news/{{$nw->post_name}}" class="newsclass"
                                target="_blank">{{$nw->post_title}}</a><br>
                            <span style="font-size:10px">{{ date('m/d/Y g:iA', strtotime($nw->post_modified)) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="col overflow-scroll scrollable-container mb-2">
                <h3><strong>Latest Appointments</strong></h3>
                <table class="table table-hover overflow-scroll">
                    <thead>
                        <tr>
                            <th scope="col"><strong>ID</strong></th>
                            <th scope="col"><strong>Email</strong></th>
                            <th scope="col"><strong>Details</strong></th>
                            <th scope="col"><strong>Date</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestappointments as $appointments)
                        <tr>
                            <td><strong>{{$appointments->id}}</strong></td>
                            <td>{{$appointments->email}}</td>
                            <td>{{$appointments->inquiry}}</td>
                            <td>{{ date('m/d/Y l', strtotime($appointments->appointeddate)) }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection