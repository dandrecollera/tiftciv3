@extends('teacher.components.layout')

@section('content')
<div class="row">
    <a href="/teacher">
        <button type="button" class="btn btn-primary mb-2">Back</button>
    </a>
    <h1>{{$subjectname->subject_name}}</h1>
    @php
    $lastsection = 0;
    @endphp
    @foreach ($sections as $section)
    @if ($section->id != $lastsection)
    <div class="col-12 col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$section->section_name}}</h6>
                <a href="/studentsgrades?subject={{$section->subjectid}}&section={{$section->sectionid}}">
                    <button type="button" class="btn btn-outline-primary btn-sm">Show Sections</button>
                </a>
            </div>
        </div>
    </div>
    @php
    $lastsection = $section->id;
    @endphp
    @endif

    @endforeach

</div>
@endsection