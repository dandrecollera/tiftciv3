@extends('student.components.layout')

@section('content')
<h1>Balance</h1>
<div class="container-lg mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title"><strong>Balance</strong></h5>
                    <h6 class="card-title">{{ $balance->school_year}}</h6>
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
                                <td>{{ $balance->voucher}}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Tuition</strong></th>
                                <td></td>
                                <td></td>
                                <td>{{ $balance->tuition}}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Registration</strong></th>
                                <td></td>
                                <td></td>
                                <td>{{ $balance->registration}}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Total</strong></th>
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