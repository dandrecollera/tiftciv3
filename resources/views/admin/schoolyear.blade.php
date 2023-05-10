@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>School Year</h1>
        </div>
    </div>
    <div class="">
        <button type="button" id="addbutton" class="btn btn-dark shadow-sm btn-sm" data-bs-toggle="modal"
            data-bs-target="#addeditmodal"><i class="fa-solid fa-circle-plus"></i> Add New School Year</button>

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
                    <button onclick="location.href='./adminschoolyear'" type="button" class="btn btn-dark"><i
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

                    <div class="input-group">
                        <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">{{$orderbylist[$sort]['display'] == 'ID' ? 'SORT' :
                            $orderbylist[$sort]['display'] }} </button>
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
                        <button onclick="location.href='./adminschoolyear'" type="button" class="btn btn-dark"><i
                                class="fas fa-search fa-rotate fa-sm"></i></button>
                        @endif
                    </div>
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
                                class="{{ $orderbylist[$sort]['display'] == 'School Year' ? 'text-primary' : '' }}"><strong>School
                                    Year</strong>
                            </span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Status' ? 'text-primary' : '' }}"><strong>Status</strong>
                            </span>
                        </th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr class="{{ $dbr->status == 'inactive' ? 'table-danger' : '' }}">
                        <th scope="row"><strong>{{$dbr->id}}</strong></th>
                        <td>{{$dbr->school_year}}</td>
                        <td>{{$dbr->status}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">

                                @if ($dbr->status != 'inactive')
                                <a class="btn btn-dark btn-sm dcc_edit" data-bs-toggle="modal"
                                    data-bs-target="#deletemodal" data-id="{{$dbr->id}}" data-qstring="{{$qstring}}"
                                    data-email="{{$dbr->school_year}}">
                                    <i class="fa-solid fa-lock fa-xs"></i></a>
                                @else
                                <a class="btn btn-success btn-sm dcc-delete" data-bs-toggle="modal"
                                    data-bs-target="#deletemodal" data-id="{{$dbr->id}}" data-qstring="{{$qstring}}"
                                    data-email="{{$dbr->school_year}}">
                                    <i class="fa-solid fa-lock-open fa-xs"></i></a>
                                @endif
                            </div>
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
                    <div>Add New School Year</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Warning</h4>
                <p>
                    Adding a new <strong>School Year</strong> will do the following functions.
                <ul>
                    <li><strong>Finalize</strong> all the student grades for the current year.</li>
                    <li><strong>Finalize</strong> all the current transaction for the current year.</li>
                </ul>
                </p>

                <hr>
                <p>
                    If you confirm the following changes, we suggest you the admin to do the following.
                <ul>
                    <li><strong>Update</strong> Schedule if there are changes.</li>
                    <li><strong>Update</strong> Section of the enrolled students.</li>
                    <li><strong>Edit Information</strong> of the current users.</li>
                </ul>
                </p>
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <a href="/adminschoolyear_add_process" class="btn btn-primary">Confirm</a>
                        <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <div><span id="titleact">Activate</span> This School Year</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span id="wordact">activate</span> <strong><span
                            id="Email"></span></strong>?<br>
                </p>
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <a href="" class="btn btn-primary" id="DeleteButton">Confirm</a>
                        <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
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
        $('#addeditmodalLabel').html('Add A New School Year');
        $('#addeditframe').attr('src', '/adminschoolyear_add?{!!$qstring!!}');
    });
    $('.dcc_edit').on('click', function() {
        console.log('delete button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var iqstring = $(this).data("qstring");
        var iemail = $(this).data("email");
        console.log(iid);
        $('#wordact').html('deactivate');
        $('#titleact').html('Deactivate');
        $('#Email').html(iemail);
        $('#DeleteButton').prop('href', '/adminschoolyear_lock_process?sid='+iid+'&'+iqstring);
    });
    $('.dcc-delete').on('click', function() {
        console.log('delete button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var iqstring = $(this).data("qstring");
        var iemail = $(this).data("email");
        console.log(iid);
        $('#wordact').html('activate');
        $('#titleact').html('Activate');
        $('#Email').html(iemail);
        $('#DeleteButton').prop('href', '/adminschoolyear_activate_process?sid='+iid+'&'+iqstring);
    });
});
</script>

@endpush