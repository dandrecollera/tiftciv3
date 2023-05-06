@extends('student.components.layout')

@section('content')
<h1>Balance</h1>
<div class="container-lg mt-4">
    <div class="row">
        <div class="col-12">
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
        </div>
    </div>
</div>
@endsection