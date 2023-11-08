@extends('alumni.components.layout')

@section('content')
@php
$sections = DB::table('students')
->where('userid', $userinfo[0])
->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
->first();

$myself = DB::table('main_users')
->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
->where('main_users.id', $userinfo[0])
->first();

$currentyear = DB::table('schoolyears')
->orderBy('id', 'desc')
->first();

@endphp
<div class="row py-3">

    <div class="col-md-8 mb-3" style="height: 80vh">
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
        <iframe src="/alumniappointment" frameborder="0" style="width:100%; height:100%"></iframe>
    </div>

    <div class="col-md-4">
        <div class="card">
            <h4 class="card-header">Latest News</h4>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($news as $nw)
                    <li class="list-group-item" aria-current="true">
                        <a href="https://tiftci.org/news/{{$nw->post_name}}" class="newsclass"
                            target="_blank">{{$nw->post_title}}</a><br>
                        <span style="font-size:10px">{{ date('m/d/Y g:iA', strtotime($nw->post_modified)) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jsscripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#documentstuff').attr('hidden', true);
        $('#yearsAttended').attr('hidden', true);
        $('#otherreasoncontainer').attr('hidden', true);

        $('#inquiry').change(function() {
            if ($(this).val() == 'Document Request') {
                $('#documentstuff').removeAttr('hidden');
            } else {
                $('#documentstuff').attr('hidden', true);
            }
        });
        $('#graduate').change(function() {
            if($(this).val() == 'Yes'){
                $('#yearsAttended').removeAttr('hidden');
                $('#labelYearAttended').html('Year Graduated*');
            } else {
                $('#yearsAttended').removeAttr('hidden');
                $('#labelYearAttended').html('Last Year Attended*');
            }
        })
        $('#others').change(function() {
            if($(this).is(':checked')) {

                $('#otherdocumentcontainer').removeAttr('hidden');
            }
            else {
                $('#otherdocumentcontainer').attr('hidden', true);
            }
        })
        $('#submitGo').click(function() {
            $(this).prop('disabled', true);
            $('#appointmentGo').submit();
        })
    });
</script>
@endpush