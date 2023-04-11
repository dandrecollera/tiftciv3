@extends('admin.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col">
            <h1>Admin User</h1>
        </div>
        <div class="col-sm-3 text-end">
            <button type="button" id="addbutton" class="btn btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#addeditmodal"><i class="fa-solid fa-circle-plus"></i> Add A New Admin User</button>
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
        <div class="col">
            <form method="get">
                <div class="input-group mb-3">
                    {!!$page_first_url!!}
                    {!!$page_prev_url!!}
                    <span class="input-group-text bg-success-subtle" id="basic-addon3">Page {{$page}} of {{$totalpages}}
                        ({{$totalitems}} Total)</span>
                    {!!$page_next_url!!}
                    {!!$page_last_url!!}

                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{{$lpp}} Items</button>
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

                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Sorted By {{$orderbylist[$sort]['display']}} </button>
                    <ul class="dropdown-menu">
                        @foreach($orderbylist as $key => $odl)
                        @php
                        $qstring2['sort'] = $key;
                        $sorturl = http_build_query($qstring2);
                        @endphp
                        <li><a class="dropdown-item" href="?{{ $sorturl }}">{{$odl['display']}}</a></li>
                        @endforeach
                    </ul>

                    <input type="text" name="keyword" class="form-control bg-success-subtle"
                        value="{{!empty($keyword) ? $keyword : ''}}" placeholder="Search Keyword"
                        aria-label="Keyword Search" aria-describedby="basic-addon2" required>
                    <button class="btn btn-success" type="submit">Go</button>
                    @if (!empty($keyword))
                    <a class="btn btn-primary" href="/adminuser" role="button">Reset Search</a>
                    @endif
                </div>
            </form>
        </div>

    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'ID' ? 'text-primary' : '' }}">ID</span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Username/Email' ? 'text-primary' : '' }}">Username/Email</span>
                        </th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Last Name' ? 'text-primary' : '' }}">Last
                                Name</span></th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'First Name' ? 'text-primary' : '' }}">First
                                Name</span></th>
                        <th scope="col"><span
                                class="{{ $orderbylist[$sort]['display'] == 'Middle Name' ? 'text-primary' : '' }}">Middle
                                Name</span></th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr class="{{ $dbr->status == 'inactive' ? 'table-danger' : '' }}">
                        <th scope="row">{{$dbr->id}}</th>
                        <td>{{$dbr->email}}</td>
                        <td>{{$dbr->lastname}}</td>
                        <td>{{$dbr->firstname}}</td>
                        <td>{{$dbr->middlename}}</td>
                        <td>{{$dbr->accounttype}}</td>
                        <td>{{$dbr->status}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Action</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item dcc_edit" href="#" data-id="{{$dbr->id}}"
                                            data-bs-toggle="modal" data-bs-target="#addeditmodal">Edit/View</a></li>
                                    <li><a class="dropdown-item"
                                            href="/adminuser_delete_process?did={{$dbr->id}}&{!!$qstring!!}"
                                            onclick="return confirm('Are you sure you want to delete {{$dbr->email}}?\nPlease note this is unrecoverable.');">Delete</a>
                                    </li>
                                </ul>
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

@push('jscripts')

<script type="text/javascript">
    $(document).ready(function(){
    $('#addbutton').on('click', function() {
        console.log('add button clicked!');
        $('#addeditmodalLabel').html('Add A New Admin User');
        $('#addeditframe').attr('src', '/adminuser_add?{!!$qstring!!}');
    });
    $('.dcc_edit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        $('#addeditmodalLabel').html('Edit This Admin User');
        $('#addeditframe').attr('src', '/adminuser_edit?id='+iid+'{!!$qstring!!}');
    });
});

</script>

@endpush