@extends('admin.components.layout')

@section('content')

<div class="container-xl mt-4">
    <h1>
        <strong>Dashboard</strong>
    </h1>
    <div class="row py-3">
        <div class="col-12 col-sm-4 mb-sm-0 mb-3">
            <div class="card text-center text-bg-dark    ">
                <div class="card-body">
                    <h6 class="card-title"># of Student</h6>
                    <h3 class="card-title">{{$studentcount}}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 mb-sm-0 mb-3">
            <div class="card text-center text-bg-dark">
                <div class="card-body">
                    <h6 class="card-title"># of Teachers</h6>
                    <h3 class="card-title">{{$teachercount}}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 mb-sm-0 mb-3">
            <div class="card text-center text-bg-dark">
                <div class="card-body">
                    <h6 class="card-title"># of Admins</h6>
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
                            <a style="color:white;" href="https://dandrecollera.com/news/{{$nw->post_name}}"
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
                            <th scope="col"><span>ID</span>
                            </th>

                            <th scope="col">Name</th>
                            <th scope="col" colspan="3">Details</th>
                            <th scope="col">Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Dandre Mitchel R. Collera</td>
                            <td colspan="3">Appointments: For enrollment</td>
                            <td>5/02/2023</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection