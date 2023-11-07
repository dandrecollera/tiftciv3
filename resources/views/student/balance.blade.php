@extends('student.components.layout')

@section('content')
<h1>Balance</h1>
<div class="container-lg mt-4">
    <div class="row">
        <div class="col-12">
            @foreach ($balances as $balance)
            @php
            $total = $balance->voucher + $balance->tuition + $balance->registration;
            @endphp
            <div class="card mb-4">
                <div class="card-body overflow-scroll">
                    <h3 class="card-title">{{ $balance->schoolyear}}</h3>
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
                                <td>₱{{ number_format($balance->voucher, 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Tuition</strong></th>
                                <td></td>
                                <td></td>
                                <td>₱{{ number_format($balance->tuition, 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Registration</strong></th>
                                <td></td>
                                <td></td>
                                <td>₱{{ number_format($balance->registration, 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><strong>Total</strong></th>
                                <td></td>
                                <td></td>
                                <td>₱{{ number_format($total, 2, '.', ',') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
