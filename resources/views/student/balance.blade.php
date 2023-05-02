@extends('student.components.layout')

@section('content')
<h1>Balance</h1>
<div class="container-lg mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
        </div>
    </div>
</div>
@endsection