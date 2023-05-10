@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Appointments</h1>
        </div>
    </div>

    <hr>
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
    <div class="row">
        <div class="col ">
            <form method="get">
                <div class="input-group mb-3">
                    <input type="search" name="keyword" class="form-control"
                        value="{{!empty($keyword) ? $keyword : ''}}" placeholder="Search Keyword"
                        aria-label="Keyword Search" aria-describedby="basic-addon2" required>
                    <button class="btn btn-dark" type="submit"><i class="fas fa-search fa-sm"></i></button>
                    @if (!empty($keyword))
                    <button onclick="location.href='./adminappointments'" type="button" class="btn btn-dark"><i
                            class="fas fa-search fa-rotate fa-sm"></i></button>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{{$lpp == 25 ? 'ITEMS' : $lpp}}</button>
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
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col overflow-scroll scrollable-container mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'ID' ? 'text-primary' : '' }}"><strong>ID</strong></span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Email' ? 'text-primary' : '' }}"><strong>Email</strong>
                            </span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Inquiry' ? 'text-primary' : '' }}"><strong>Inquiry</strong>
                            </span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Appointed Date' ? 'text-primary' : '' }}"><strong>Appointed
                                    Date</strong>
                            </span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Created Date' ? 'text-primary' : '' }}"><strong>Created
                                    Date</strong>
                            </span>
                        </th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr>
                        <th scope="row"><strong>{{$dbr->id}}</strong></th>
                        <td>{{$dbr->email}}</td>
                        <td>{{$dbr->inquiry}}</td>
                        <td>{{ date('m/d/Y l', strtotime($dbr->appointeddate)) }}</td>
                        <td>{{ date_create($dbr->created_at)->format('m/d/Y h:i A') }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-dark btn-sm" href="#" data-bs-target="#subjectTeacher{{$dbr->id}}"
                                    data-bs-toggle="collapse" data-bs-target="#addeditmodal"><i
                                        class="fa-solid fa-caret-down fa-xs"></i></a>
                                <a class="btn btn-success btn-sm dcc-delete" data-bs-toggle="modal"
                                    data-bs-target="#deletemodal" data-id="{{$dbr->id}}" data-qstring="{{$qstring}}"
                                    data-email="{{$dbr->email}}">
                                    <i class="fa-solid fa-check fa-xs"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr id="subjectTeacher{{$dbr->id}}" class="collapse">
                        <td colspan="6">
                            <iframe id="" src="/adminappointments_info?sid={{$dbr->id}}" width="100%" height="500px"
                                style="border:none;"></iframe>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="input-group mb-4">
            {!!$page_first_url!!}
            {!!$page_prev_url!!}
            <span class="input-group-text bg-dark text-white w-auto" id="basic-addon3">{{$page}}/{{$totalpages}}</span>
            {!!$page_next_url!!}
            {!!$page_last_url!!}
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
                <iframe id="addeditframe" src="/adminsection_add" width="100%" height="450px"
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
                    <div>Complete This Appointment</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to complete this appointment by <strong><span id="Email"></span></strong>?<br>
                    Confirming will clear this appointment.
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
        $('#addeditmodalLabel').html('Add A New Section');
        $('#addeditframe').attr('src', '/adminsection_add?{!!$qstring!!}');
    });
    $('.dcc_edit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        console.log(iid);
        $('#addeditmodalLabel').html('Edit This Section');
        $('#addeditframe').attr('src', '/adminsection_edit?id='+iid+'&{!!$qstring!!}');
    });
    $('.dcc-delete').on('click', function() {
        console.log('delete button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var iqstring = $(this).data("qstring");
        var iemail = $(this).data("email");
        console.log(iid);
        $('#Email').html(iemail);
        $('#DeleteButton').prop('href', '/adminappointments_delete_process?sid='+iid+'&'+iqstring);
    });
});
</script>

@endpush