@extends('teacher.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <a href="/section?subject={{$qstring2['subject']}}">
            <button type="button" class="btn btn-primary mb-2">Back</button>
        </a>
        <h1 class="mb-3">{{$subject->subject_name}}: {{$section->section_name}}</h1>
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
            <div class="col overflow-scroll scrollable-container mb-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">1st</th>
                            <th scope="col">2nd</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $dbr)
                        <tr class="">
                            <th scope="row">{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}</th>
                            <td>89</td>
                            <td>78</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-primary btn-sm dcc_edit" href="#" data-id="{{$dbr->userid}}"
                                        data-bs-toggle="modal" data-bs-target="#addeditmodal"><i
                                            class="fa-solid fa-pen fa-xs"></i></a>
                                    <a class="btn btn-danger btn-sm"
                                        href="/adminstudent_delete_process?did={{$dbr->userid}}&{!!$qstring!!}"
                                        onclick="return confirm('Are you sure you want to delete {{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}?\nPlease note this is unrecoverable.');"><i
                                            class="fa-solid fa-trash fa-xs"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
        $('#addeditmodalLabel').html('Add A New Student User');
        $('#addeditframe').attr('src', '/adminstudent_add?{!!$qstring!!}');
    });
    $('.dcc_edit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        console.log(iid);
        $('#addeditmodalLabel').html('Edit This Student User');
        $('#addeditframe').attr('src', '/adminstudent_edit?id='+iid+'{!!$qstring!!}');
    });
});

</script>

@endpush