@extends('admin.components.modal')

@section('style')
<style>
    label {
        font-size: 14px;
        font-weight: 500;
    }
</style>
@endsection


@section('content')
<div style="padding: 0px 20px 0px 10px">
    <form action="/studentsgrades_edit_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <div class="form-outline mt-2 mb-5">
                <input type="number" class="form-control" name="grade" id="grade" value="{{$score->grade}}" required>
                <label for="grade" class="form-label">Grade:</label>
                <div class="form-helper">Set the Student's Grade</div>
            </div>

            <input type="hidden" name="gid" value="{{$gid}}">
            <input type="hidden" name="sid" value="{{$sid}}">
            <input type="hidden" name="subject" value="{{$subject}}">
            <input type="hidden" name="section" value="{{$section}}">
            <input type="hidden" name="quarter" value="{{$quarter}}">
            <button type="submit" class="btn btn-primary float-end">Set</button>
        </div>
    </form>
</div>
@endsection