@extends('student.components.layout')
@php
$myappointments = DB::table('appointments')
->where('email', $userinfo[4])
->get()
->toArray();
@endphp
@section('content')
<h1>My Appointments</h1>
<button type="button" id="addbutton" class="btn btn-warning shadow-sm btn-sm" data-bs-toggle="modal"
    data-bs-target="#addeditmodal"><i class="fa-solid fa-circle-plus"></i>Add A New Appointment</button>
<div class="container-lg mt-4">
    @if (!empty($error))
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
    @endif
</div>
<hr>
<div class="container-lg mt-4">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myappointments as $appointments)
                            <tr>
                                <td><strong>{{$appointments->inquiry}}</td>
                                <th></th>
                                <th></th>
                                <td>{{ date_create($appointments->created_at)->format('m/d/Y h:i A') }}</td>
                                <th>{{ date('m/d/Y l', strtotime($appointments->appointeddate)) }}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
});

</script>

@endpush