@extends('teacher.components.layout')

@section('content')
<div class="row">
    <h1 class="mb-3">My Subjects</h1>
    @foreach ($subjects as $subject)
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
    @endforeach

</div>
@endsection