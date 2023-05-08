@extends('admin.components.modal')

@section('style')
<style>
    body {
        background: rgba(236, 236, 236, 0.4);
    }

    label {
        font-size: 14px;
        font-weight: 500;
    }

    * {
        scrollbar-width: auto;
        scrollbar-color: rgba(0, 0, 0, 0.2) rgba(0, 0, 0, 0.2);
    }

    /* Chrome, Edge, and Safari */
    ::-webkit-scrollbar {
        width: 2px;
        height: 2px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.0);
    }
</style>
@endsection

@section('content')
<div class="py-3 px-5">
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
    <h4>{{ $section->section_name }} Subject/Schedule</h4>
    <div class="">
        <button type="button" id="addbutton" class="btn btn-dark btn-sm" data-bs-toggle="modal"
            data-bs-target="#addeditmodal"><i class="fa-solid fa-circle-plus"></i> Add Subject/Schedule</button>
    </div>
    <hr>
    <div class="row">
        <div class="col ">
            <form method="get">
                <div class="input-group mb-3">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Sorted By {{$orderbylist[$sort]['display']}} </button>
                    <ul class="dropdown-menu">
                        @foreach($orderbylist as $key => $odl)
                        @php
                        $qstring2['sort'] = $key;
                        $query = array_merge(request()->query(), $qstring2);
                        $sorturl = http_build_query($query);
                        $currentUrl = url()->current();
                        @endphp
                        <li><a class="dropdown-item" href="{{ $currentUrl }}?{{ $sorturl }}">{{ $odl['display'] }}</a>
                        </li>
                        @endforeach
                    </ul>

                    @php
                    $day = request()->input('day');
                    @endphp
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{{empty($day) ? "Filter to Day" : "Filter to ".$day}}</button>
                    <ul class="dropdown-menu">
                        @php
                        $currentUrl = url()->current();
                        $query = request()->getQueryString();
                        $sid = request()->input('sid');
                        @endphp
                        <li><a class="dropdown-item"
                                href="{{ $currentUrl }}?{{ $query }}&sid={{ $sid }}&day=Monday">Monday</a></li>
                        <li><a class="dropdown-item"
                                href="{{ $currentUrl }}?{{ $query }}&sid={{ $sid }}&day=Tuesday">Tuesday</a></li>
                        <li><a class="dropdown-item"
                                href="{{ $currentUrl }}?{{ $query }}&sid={{ $sid }}&day=Wednesday">Wednesday</a></li>
                        <li><a class="dropdown-item"
                                href="{{ $currentUrl }}?{{ $query }}&sid={{ $sid }}&day=Thursday">Thursday</a></li>
                        <li><a class="dropdown-item"
                                href="{{ $currentUrl }}?{{ $query }}&sid={{ $sid }}&day=Friday">Friday</a></li>
                    </ul>
                    @if (!empty($day))
                    @php
                    $currentUrl = url()->current();
                    $query = request()->getQueryString();
                    $sid = request()->input('sid');
                    @endphp
                    <a class="btn btn-dark" href="{{ $currentUrl }}?sid={{ $sid }}" role="button">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="row fs-6">
        <div class="col overflow-scroll scrollable-container mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><strong>Subject</strong></th>
                        <th scope="col" class="{{ $orderbylist[$sort]['display'] == 'Start' ? 'text-primary' : '' }}">
                            <strong>Start</strong>
                        </th>
                        <th scope="col" class="{{ $orderbylist[$sort]['display'] == 'End' ? 'text-primary' : '' }}">
                            <strong>End</strong>
                        </th>
                        <th scope="col" class="{{ $orderbylist[$sort]['display'] == 'Day' ? 'text-primary' : '' }}">
                            <strong>Day</strong>
                        </th>
                        <th scope="col"><strong>Teacher</strong></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr>
                        <th><strong>{{$dbr->subject_name}}</strong></th>
                        <td>{{$dbr->start_time}}</td>
                        <td>{{$dbr->end_time}}</td>
                        <td>{{$dbr->day}}</td>
                        <td>{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-danger btn-sm dcc-delete" data-bs-toggle="modal"
                                    data-bs-target="#deletemodal" data-id="{{$dbr->id}}" data-sid="{{$dbr->sectionid}}"
                                    data-email="{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}">
                                    <i class="fa-solid fa-trash fa-xs"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addeditmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addeditmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addeditmodalLabel">
                    <div>Add Class Subject</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="addeditframe" src="/adminschedule_add?sid={{ $qsid }}" width="100%" height="450px"
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
    $('.dcc-delete').on('click', function() {
        console.log('delete button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var iqstring = $(this).data("sid");
        var iemail = $(this).data("email");
        console.log(iid);
        $('#Email').html(iemail);
        $('#DeleteButton').prop('href', '/adminschedule_delete_process?did='+iid+'&sid='+iqstring);
    });
});
</script>

@endpush