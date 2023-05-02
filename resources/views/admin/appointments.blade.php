@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Appointments</h1>
        </div>
    </div>
    <hr>
    {{-- @if (!empty($error))
    <div class="row">
        <div class="col">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Error</h4>
                <p>{{ $errorlist[(int) $error ] }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
    @if (!empty($notif))
    <div class="row">
        <div class="col">
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Success</h4>
                <p>{{ $notiflist[(int) $notif ] }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif --}}
    {{-- <div class="row">
        <div class="col ">
            <form method="get">
                <div class="input-group mb-3">
                    <input type="text" name="keyword" class="form-control bg-success-subtle"
                        value="{{!empty($keyword) ? $keyword : ''}}" placeholder="Search Keyword"
                        aria-label="Keyword Search" aria-describedby="basic-addon2" required>
                    <button class="btn btn-success" type="submit">Go</button>
                    @if (!empty($keyword))
                    <a class="btn btn-primary" href="/adminstudent" role="button">Reset</a>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{{$lpp}} Items</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?lpp=3{{!empty($keyword) ? " &keyword=".$keyword : ''}}">3
                                Lines Per Page</a></li>
                        <li><a class="dropdown-item" href="?lpp=25{{!empty($keyword) ? " &keyword=".$keyword : ''}}">25
                                Lines Per Page</a></li>
                        <li><a class="dropdown-item" href="?lpp=50{{!empty($keyword) ? " &keyword=".$keyword : ''}}">50
                                Lines Per Page</a></li>
                        <li><a class="dropdown-item" href="?lpp=100{{!empty($keyword) ? "
                                &keyword=".$keyword : ''}}">100 Lines Per page</a></li>
                        <li><a class="dropdown-item" href="?lpp=200{{!empty($keyword) ? "
                                &keyword=".$keyword : ''}}">200 Lines Per Page</a></li>
                    </ul>

                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Sorted By {{$orderbylist[$sort]['display']}} </button>
                    <ul class="dropdown-menu">
                        @foreach($orderbylist as $key => $odl)
                        @php
                        $qstring2['sort'] = $key;
                        $sorturl = http_build_query($qstring2);
                        @endphp
                        <li><a class="dropdown-item" href="?{{ $sorturl }}">{{$odl['display']}}</a></li>
                        @endforeach
                    </ul>
                </div>

            </form>
        </div>

    </div> --}}
    <div class="row">
        <div class="col overflow-scroll scrollable-container mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span>ID</span>
                        </th>

                        <th scope="col">Name</th>
                        <th scope="col" colspan="3">>Details</th>
                        <th scope="col">Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Dandre Mitchel R. Collera</td>
                        <td colspan="3">Appointments: For enrollment</td>
                        <td>5/02/2023</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-success btn-sm"><i class="fa-solid fa-check fa-xs"></i></a>
                                <a class="btn btn-danger btn-sm"> <i class="fa-solid fa-close fa-xs"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Test Name</td>
                        <td colspan="3">Appointments: For enrollment</td>
                        <td>5/02/2023</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-success btn-sm"><i class="fa-solid fa-check fa-xs"></i></a>
                                <a class="btn btn-danger btn-sm"> <i class="fa-solid fa-close fa-xs"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>





@endsection

@push('jsscripts')


@endpush