@extends('admin.components.layout')

@section('content')

<div class="container-xl mt-4">
    <h4>not functional: need student function, no public connection</h4>
    <h1>Dashboard</h1>
    <div class="row py-3">
        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title"># of Student</h6>
                    <h3 class="card-title">400</h3>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title"># of Teachers</h6>
                    <h3 class="card-title">13</h3>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title"># of Admins</h6>
                    <h3 class="card-title">4</h3>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row py-3">
        <div class="col-9">
            <div class="col overflow-scroll scrollable-container mb-2">
                <h3>Latest Appointments</h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><span>ID</span>
                            </th>

                            <th scope="col">Name</th>
                            <th scope="col" colspan="3">Details</th>
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
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Latest News</h6>
                    <h6 class="card-title">No Recent News</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection