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
    <form action="/adminsubject_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">


            <div class="form-outline mt-2 mb-2">
                <input type="text" class="form-control" name="subjectname" id="Subject" required>
                <label for="Subject" class="form-label">Subject Name:</label>
            </div>


            <label for="emailInput" class="form-label">Semester</label>
            <div class="input-group mb-3">
                <select name="semester" id="strandInput" class="form-select" required>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary float-end">Save</button>
        </div>
    </form>
</div>
@endsection