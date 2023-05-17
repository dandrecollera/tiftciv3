@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Teachers</h1>
        </div>
    </div>
    <div class="">
        <button type="button" id="addbutton" class="btn btn-dark shadow-sm btn-sm" data-bs-toggle="modal"
            data-bs-target="#addeditmodal"><i class="fa-solid fa-circle-plus"></i> Add A New Teacher
            User</button>
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
                        value="{{!empty($keyword) ? $keyword : ''}}" placeholder="Search Keyword" required>
                    <button class="btn btn-dark" type="submit"><i class="fas fa-search fa-sm"></i></button>
                    @if (!empty($keyword))
                    <button onclick="location.href='./adminteacher'" type="button" class="btn btn-dark"><i
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
                            aria-expanded="false">{{$orderbylist[$sort]['display'] == 'Default' ? 'SORT' :
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
                        @if (!empty($sort) || $lpp != 25)
                        <button onclick="location.href='./adminteacher'" type="button" class="btn btn-dark"><i
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
                                class="{{ $orderbylist[$sort]['display'] == 'ID' ? 'text-primary' : '' }}"><strong></strong></span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Email' ? 'text-primary' : '' }}"><strong>Email</strong></span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Last Name' ? 'text-primary' : '' }}"><strong>Last
                                    Name</strong></span></th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'First Name' ? 'text-primary' : '' }}"><strong>First
                                    Name</strong></span></th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Middle Name' ? 'text-primary' : '' }}"><strong>Middle
                                    Name</strong></span></th>
                        <th scope="col"><strong>Status</strong></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr class="{{ $dbr->status == 'inactive' ? 'table-danger' : '' }}">
                        <th scope="row"><strong><img src="{{ asset('/storage/images/' . $dbr->photo) }}"
                                    class="rounded-circle me-lg-0 me-2 dpcover" height="40" width="40" alt=""
                                    loading="lazy" /></strong></th>
                        <td>{{$dbr->email}}</td>
                        <td>{{$dbr->lastname}}</td>
                        <td>{{$dbr->firstname}}</td>
                        <td>{{$dbr->middlename}}</td>
                        <td>{{$dbr->status}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-primary btn-sm dcc_edit" href="#" data-id="{{$dbr->id}}"
                                    data-bs-toggle="modal" data-bs-target="#addeditmodal"><i
                                        class="fa-solid fa-pen fa-xs"></i></a>
                                <a class="btn btn-danger btn-sm dcc-delete" data-bs-toggle="modal"
                                    data-bs-target="#deletemodal" data-id="{{$dbr->id}}" data-qstring="{{$qstring}}"
                                    data-email="{{$dbr->email}}">
                                    <i class="fa-solid fa-trash fa-xs"></i></a>
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
                    <div>Modal title</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="addeditframe" width="100%" height="450px" style="border:none; height:80vh;"></iframe>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <div>Delete This Teacher User</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong><span id="Email"></span></strong>?<br>
                    Please note this is unrecoverable.
                </p>
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <a href="" class="btn btn-danger" id="DeleteButton">DELETE</a>
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
        $('#addeditmodalLabel').html('Add A New Teacher User');
        $('#addeditframe').attr('src', '/adminteacher_add?{!!$qstring!!}');
    });
    $('.dcc_edit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        console.log(iid);
        $('#addeditmodalLabel').html('Edit This Teacher User');
        $('#addeditframe').attr('src', '/adminteacher_edit?id='+iid+'{!!$qstring!!}');
    });
    $('.dcc-delete').on('click', function() {
        console.log('delete button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var iqstring = $(this).data("qstring");
        var iemail = $(this).data("email");
        console.log(iid);
        $('#Email').html(iemail);
        $('#DeleteButton').prop('href', '/adminteacher_delete_process?did='+iid+'&'+iqstring);
    });
});
</script>

@endpush