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

            <label for="emailInput" class="form-label">Grade</label>
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="School Year" name="grade" id="sectionInput"
                    value="{{$score->grade}}" required>
            </div>


            <input type="text" name="gid" value="{{$gid}}">
            <input type="text" name="sid" value="{{$sid}}">
            <input type="text" name="subject" value="{{$subject}}">
            <input type="text" name="section" value="{{$section}}">
            <input type="text" name="quarter" value="{{$quarter}}">
            <button type="submit" class="btn btn-primary float-end">Set</button>
        </div>
    </form>
</div>
@endsection