@extends('student.components.layout')

@section('content')
<h1>Schedule</h1>
<div class="container-lg mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Monday</h5>
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
                                <td>8:00AM</td>
                                <td>9:30AM</td>
                                <td>Monday</td>
                                <td>Dandre Collera</td>
                            </tr>
                            <tr>
                                <th scope="row">Subject 1</th>
                                <td>9:30AM</td>
                                <td>11:00AM</td>
                                <td>Monday</td>
                                <td>Dandre Collera</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-lg mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
</div>
@endsection