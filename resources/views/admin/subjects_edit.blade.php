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
    <form action="/adminsubject_edit_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <label for="emailInput" class="form-label">Subject Name</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Subject" name="subjectname" id="subjectInput"
                    value="{{ $dbdata->subject_name }}" required>
            </div>

            <div class="input-group mb-3">
                <select name="semester" id="strandInput" class="form-select" required>
                    <option value="1st" {{ $dbdata->semester == "1st" ? 'selected' : ''}}>1st</option>
                    <option value="2nd" {{ $dbdata->semester == "2nd" ? 'selected' : ''}}>2nd</option>
                </select>
            </div>

            <input type="hidden" name="did" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>
        </div>
    </form>
</div>
@endsection