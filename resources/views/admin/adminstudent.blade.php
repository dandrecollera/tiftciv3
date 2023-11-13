@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Students</h1>
        </div>
    </div>
    <div class="btn-group">
        <button type="button" id="addbutton" class="btn btn-dark shadow-sm btn-sm" data-bs-toggle="modal"
            data-bs-target="#addeditmodal"><i class="fa-solid fa-circle-plus"></i> Add A New Student</button>

        <button type="button" id="massAdd" class="btn btn-dark shadow-sm btn-sm" data-bs-toggle="modal"
            data-bs-target="#addeditmodal"><i class="fa-solid fa-circle-plus"></i> Batch Add Students</button>
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
                    <button onclick="location.href='./adminstudent'" type="button" class="btn btn-dark"><i
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
                        <button onclick="location.href='./adminstudent'" type="button" class="btn btn-dark"><i
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
                                class="{{ $orderbylist[$sort]['display'] == 'Username/Email' ? 'text-primary' : '' }}"><strong>Username/Email</strong></span>
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

                        <th scope="col"><strong>Section</strong></th>
                        <th scope="col"><strong>LRN</strong></th>
                        <th scope="col"><strong>Status</strong></th>
                        <th scope="col"><strong>Actions</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr class="{{ $dbr->status == 'inactive' ? 'table-danger' : '' }}">
                        <th scope="row"><img src="{{ asset('/storage/images/' . $dbr->photo) }}"
                                class="rounded-circle me-lg-0 me-2 dpcover" height="40" width="40" alt=""
                                loading="lazy" /></th>
                        <td>{{$dbr->email}}</td>
                        <td>{{$dbr->lastname}}</td>
                        <td>{{$dbr->firstname}}</td>
                        <td>{{$dbr->middlename}}</td>
                        <td>
                            @php
                            $latestSection = DB::table('students')
                            ->where('userid', $dbr->id)
                            ->orderBy('id', 'desc')
                            ->first();

                            $thesection = DB::table('curriculums')
                            ->where('id', $latestSection->sectionid)
                            ->first();

                            @endphp
                            {{$thesection->name}}
                        </td>
                        <td>{{$dbr->lrn}}</td>
                        <td>{{$dbr->status}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                {{-- <a class="btn btn-success btn-sm" href="#"
                                    data-bs-target="#subjectTeacher{{$dbr->id}}" data-bs-toggle="collapse"
                                    data-bs-target="#addeditmodal"><i class="fa-solid fa-peso-sign fa-xs"></i></a> --}}
                                <a class="btn btn-primary btn-sm dcc_edit" href="#" data-id="{{$dbr->id}}"
                                    data-bs-toggle="modal" data-bs-target="#addeditmodal"><i
                                        class="fa-solid fa-pen fa-xs"></i></a>
                                <a class="btn btn-warning btn-sm dcc-archive" data-bs-toggle="modal"
                                    data-bs-target="#deletemodal" data-id="{{$dbr->id}}" data-stat="{{$dbr->status}}"
                                    data-qstring=" {{$qstring}}" data-email="{{$dbr->email}}">
                                    <i class="fa-solid fa-box-archive fa-xs"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr id="subjectTeacher{{$dbr->id}}" class="collapse">
                        <td colspan="9">
                            <iframe id="" src="/admintransaction?sid={{$dbr->id}}" width="100%" height="500px"
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
                    <div id="arctitle">Archive This Student User</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span id="arctext">archive</span> <strong><span
                            id="Email"></span></strong>?<br>
                </p>
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <a href="" class="btn btn-warning" id="DeleteButton">Archive</a>
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
        $('#addeditmodalLabel').html('Add A New Student User');
        $('#addeditframe').attr('src', '/adminstudent_add?{!!$qstring!!}');
    });
    $('#massAdd').on('click', function() {
        console.log('add button clicked!');
        $('#addeditmodalLabel').html('Batch Add Students');
        $('#addeditframe').attr('src', '/adminstudent_batchadd?{!!$qstring!!}');
    });
    $('.dcc_edit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        console.log(iid);
        $('#addeditmodalLabel').html('Edit This Student User');
        $('#addeditframe').attr('src', '/adminstudent_edit?id='+iid+'{!!$qstring!!}');
    });
    $('.dcc-archive').on('click', function() {
        if($(this).data('stat') == 'inactive'){
            $('#arctitle').text('Unarchive This Student User');
            $('#arctext').text('unarchive');
            $('#DeleteButton').text('Unarchive');
        } else {
            $('#arctitle').text('Archive This Student User');
            $('#arctext').text('archive');
            $('#DeleteButton').text('Archive');
        }
        var iid = $(this).data("id");
        var iqstring = $(this).data("qstring");
        var iemail = $(this).data("email");
        $('#Email').html(iemail);
        $('#DeleteButton').prop('href', '/adminstudent_archive_process?did='+iid+'&'+iqstring);
    });
});

</script>

@endpush