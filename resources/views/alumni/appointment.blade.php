@extends('alumni.components.layout')
@php

$seenstatus = DB::table('appointments')
->where('email', '=', $userinfo[4])
->where(function ($query) {
$query->where('active', '=', 'Approved')
->orWhere('active', '=', 'Declined')
->orWhere('active', '=', 'Completed');
})
->where('seen', '=', 0)
->update([
'seen' => 1
]);

@endphp
@section('content')
<h1>My Appointments</h1>
<hr>
<div class="container-lg mt-4">
    <div class="input-group">
        <button class="btn btn-warning dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">{{$orderbylist[$sort]['display'] == 'Default' ? 'SORT' :
            $orderbylist[$sort]['display'] }}</button>
        <ul class="dropdown-menu">
            @foreach($orderbylist as $key => $odl)
            @php
            $qstring2['sort'] = $key;
            $sorturl = http_build_query($qstring2);
            @endphp
            <li><a class="dropdown-item" href="?{{ $sorturl }}">{{$odl['display']}}</a></li>
            @endforeach
        </ul>
        @if (!empty($sort))
        <button onclick="location.href='./alumniappointmentslist'" type="button" class="btn btn-dark"><i
                class="fas fa-search fa-rotate fa-sm"></i></button>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><strong>Inquiry<strong></th>
                                <th></th>
                                <th></th>
                                <th><strong>Created<strong></th>
                                <th><strong>Appointed Date</strong></th>
                                <th><strong>Status</strong></th>
                                <th><strong></strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myappointments as $appointments)
                            <tr style="background-color: {{ $appointments->active == 'Pending' ? 'rgb(236, 236, 191)' : ''}}
                                {{ $appointments->active == 'Completed' ? 'rgb(201, 236, 191)' : ''}}
                                {{ $appointments->active == 'Declined' ? 'rgb(238, 212, 218)' : ''}}
                                {{ $appointments->active == 'Cancelled' ? 'rgb(238, 212, 218)' : ''}}
                                {{ $appointments->active == 'Approved' ? 'rgb(212, 238, 232)' : ''}}">
                                <td><strong>{{$appointments->inquiry}}</td>
                                <th style=""></th>
                                <th></th>
                                <td>{{ date_create($appointments->created_at)->format('m/d/Y h:i A') }}</td>
                                <th>{{ date('m/d/Y l', strtotime($appointments->appointeddate)) }}</th>
                                <td><strong>{{$appointments->active}}</td>
                                @if ($appointments->active == "Pending" || $appointments->active == "Approved")
                                <td><a class="btn btn-danger btn-sm dcc-approve" data-bs-toggle="modal"
                                        data-bs-target="#deletemodal" data-id="{{$appointments->id}}"
                                        data-qstring="{{$qstring}}" data-email="{{$appointments->email}}"><i
                                            class="fa-solid fa-close fa-xs"></i></a></td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        {!!$page_first_url!!}
                        {!!$page_prev_url!!}
                        <span class="input-group-text bg-warning text-white w-auto"
                            id="basic-addon3">{{$page}}/{{$totalpages}}</span>
                        {!!$page_next_url!!}
                        {!!$page_last_url!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addeditmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addeditmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addeditmodalLabel">
                    <div>Modal title</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="addeditframe" src="/adminuser_add" width="100%" height="450px"
                    style="border:none; height:80vh;"></iframe>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <div id="modtitle"></div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modbod">
                </p>
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <a href="" class="btn btn-success" id="DeleteButton">Confirm</a>
                        <a class="btn btn-primary" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function(){
    $('#addbutton').on('click', function() {
        console.log('add button clicked!');
        $('#addeditmodalLabel').html('Add Appointment');
        $('#addeditframe').attr('src', '/studentappointment_add');
    });
    $('.dcc_edit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        console.log(iid);
        $('#addeditmodalLabel').html('Edit This Student User');
        $('#addeditframe').attr('src', '/adminstudent_edit?id='+iid+'{!!$qstring!!}');
    });
    $('.dcc-delete').on('click', function() {
        console.log('delete button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var iqstring = $(this).data("qstring");
        var iemail = $(this).data("email");
        console.log(iid);
        $('#Email').html(iemail);
        $('#DeleteButton').prop('href', '/adminstudent_delete_process?did='+iid+'&'+iqstring);
    });
    $('.dcc-approve').on('click', function() {
        console.log('delete button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var iqstring = $(this).data("qstring");
        var iemail = $(this).data("email");
        console.log(iid);
        $('#modtitle').html('Cancel this appointment?');
        $('#modbod').html('Are you sure you want to cancel this appointment?<br>');
        $('#Email').html(iemail);
        $('#DeleteButton').addClass('btn-danger').removeClass('btn-success');
        $('#DeleteButton').html('Confirm');
        $('#DeleteButton').prop('href', '/studentappointment_cancel_process?sid='+iid+'&'+iqstring);
    });
});

</script>

@endpush