@extends('teacher.components.layout')

@section('content')
<div class="row">
    <h1 class="">Grading</h1>
    <h5 class="mb-3">Select a subject to see the list of sections</h5>
    @php
    $lastsubjectid = 999
    @endphp
    @foreach ($subjects as $subject)
    @if ($subject->subjectid != $lastsubjectid)
    <div class="col-12 col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$subject->subject_name}}</h6>
                <a href="/section?subject={{$subject->subjectid}}">
                    <button type="button" class="btn btn-outline-primary btn-sm">Show Sections</button>
                </a>
            </div>
        </div>
    </div>
    @php
    $lastsubjectid = $subject->subjectid;
    @endphp
    @endif

    @endforeach

</div>
@endsection