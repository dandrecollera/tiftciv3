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
    {{-- <h4>{{ $section->section_name }} Subject/Schedule</h4> --}}

    <h2>Subjects</h2>

    <div class="row fs-6">
        <div class="col overflow-scroll scrollable-container mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><strong>Subject</strong></th>
                        <th scope="col"><strong>Teacher</strong></th>
                        <th scope="col">
                            <strong>Start</strong>
                        </th>
                        <th scope="col">
                            <strong>End</strong>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $csttArray = json_decode($subjects->cstt, true);
                    @endphp

                    @foreach ($csttArray as $dbr)

                    @php
                    $subject = DB::table('subjects')
                    ->where('id', $dbr['teacherid'])
                    ->first();


                    $teacher = DB::table('main_users')
                    ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
                    ->where('main_users.id', $dbr['teacherid'])
                    ->first();
                    // dd($teacher);
                    @endphp
                    <tr>
                        <th><strong>{{ $subject->subject_name}}</strong></th>
                        <th>{{ $teacher->firstname }} {{ $teacher->middlename }} {{ $teacher->lastname}}</th>
                        <td>{{ \Carbon\Carbon::parse($dbr['starttime'])->format('h:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($dbr['endtime'])->format('h:i A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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