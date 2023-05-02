@extends('student.components.layout')

@section('content')
<div class="row py-3">
    <div class="col-9">
        <div class="col overflow-scroll scrollable-container mb-2">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <h5 class="card-title">2022-2023</h5>
                    <h6 class="card-subtitle mb-2 text-muted">1st Semester</h6>
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
                                <th scope="row">General</th>
                                <td></td>
                                <td></td>
                                <td>1,500</td>
                            </tr>
                            <tr>
                                <th scope="row">Msc</th>
                                <td></td>
                                <td></td>
                                <td>1,500</td>
                            </tr>
                            <tr>
                                <th scope="row">Subjects</th>
                                <td></td>
                                <td></td>
                                <td>1,500</td>
                            </tr>
                            <tr>
                                <th scope="row">Books</th>
                                <td></td>
                                <td></td>
                                <td>1,500</td>
                            </tr>
                            <tr>
                                <th scope="row">Uniform</th>
                                <td></td>
                                <td></td>
                                <td>1,500</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Schedule</h5>
                    <h5 class="card-title">Tuesday</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Subjects</th>
                                <th scope="col">Start</th>
                                <th scope="col">End</th>
                                <th scope="col">Day</th>
                                <th scope="col">Teacher</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Main Subject</th>
                                <td>10:00AM</td>
                                <td>11:00AM</td>
                                <td>Tuesday</td>
                                <td>Dandre Collera</td>
                            </tr>
                            <tr>
                                <th scope="row">Subject 1</th>
                                <td>1:00PM</td>
                                <td>3:00PM</td>
                                <td>Tuesday</td>
                                <td>Dandre Collera</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
@endsection