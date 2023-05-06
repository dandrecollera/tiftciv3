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
                            <th scope="col">{{$subject->semester == "1st" ? '1st' : '3rd'}}</th>
                            <th scope="col">{{$subject->semester == "1st" ? '2nd' : '4th'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $dbr)
                        <tr>
                            <th scope="row">{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}</th>
                            @php
                            $grades = DB::table('grades')
                            ->where('studentid', $dbr->userid)
                            ->where('subjectid', $qstring2['subject'])
                            ->select('grades.grade', 'grades.quarter')
                            ->get()
                            ->toArray();
                            $firstQuarterGrade = '';
                            $secondQuarterGrade = '';
                            foreach ($grades as $grade) {
                            if ($grade->quarter == "1st" || $grade->quarter == "3rd") {
                            $firstQuarterGrade = $grade->grade;
                            } elseif ($grade->quarter == "2nd" || $grade->quarter == "4th") {
                            $secondQuarterGrade = $grade->grade;
                            }
                            }
                            @endphp
                            <td>
                                @if ($firstQuarterGrade)
                                {{$firstQuarterGrade}}
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-success btn-sm topedit" href="#" data-id="{{$dbr->userid}}"
                                        data-quarter="{{$subject->semester == '1st' ? '1st' : '3rd' }}"
                                        data-bs-toggle="modal" data-bs-target="#addeditmodal"><i
                                            class="fa-solid fa-pen"></i></a>
                                </div>
                                @else
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-primary btn-sm topgrade" href="#" data-id="{{$dbr->userid}}"
                                        data-quarter="{{$subject->semester == '1st' ? '1st' : '3rd' }}"
                                        data-bs-toggle="modal" data-bs-target="#addeditmodal"><i
                                            class="fa-solid fa-plus"></i></a>
                                </div>

                                @endif
                            </td>
                            <td>
                                @if ($secondQuarterGrade)
                                {{$secondQuarterGrade}}
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-success btn-sm bottomedit" href="#" data-id="{{$dbr->userid}}"
                                        data-quarter="{{$subject->semester == '1st' ? '2nd' : '4th' }}"
                                        data-bs-toggle="modal" data-bs-target="#addeditmodal"><i
                                            class="fa-solid fa-pen"></i></a>
                                </div>
                                @else

                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-primary btn-sm bottomgrade" href="#" data-id="{{$dbr->userid}}"
                                        data-quarter="{{$subject->semester == '1st' ? '2nd' : '4th' }}"
                                        data-bs-toggle="modal" data-bs-target="#addeditmodal"><i
                                            class="fa-solid fa-plus"></i></a>
                                </div>
                                @endif
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
    $('.topgrade').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        console.log(iid);
        $('#addeditmodalLabel').html('{{$subject->semester == "1st" ? '1st' : '3rd'}}');
        $('#addeditframe').attr('src', '/studentsgrades_add?id='+iid+'&quarter='+quart+'&{!!$qstring!!}');
    });
    $('.bottomgrade').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        console.log(iid);
        $('#addeditmodalLabel').html('{{$subject->semester == "1st" ? '2nd' : '4th'}}');
        $('#addeditframe').attr('src', '/studentsgrades_add?id='+iid+'&quarter='+quart+'&{!!$qstring!!}');
    });


    $('.topedit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        console.log(iid);
        $('#addeditmodalLabel').html('{{$subject->semester == "1st" ? '2nd' : '4th'}}');
        $('#addeditframe').attr('src', '/studentsgrades_edit?id='+iid+'&quarter='+quart+'&{!!$qstring!!}');
    });
    $('.bottomedit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        console.log(iid);
        $('#addeditmodalLabel').html('{{$subject->semester == "1st" ? '2nd' : '4th'}}');
        $('#addeditframe').attr('src', '/studentsgrades_edit?id='+iid+'&quarter='+quart+'&{!!$qstring!!}');
    });
});

</script>

@endpush