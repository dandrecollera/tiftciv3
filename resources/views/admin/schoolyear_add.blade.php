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
    <form action="/adminschoolyear_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <label for="emailInput" class="form-label">School Year</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="School Year" name="schoolyear" id="sectionInput"
                    required>
            </div>

            <button type="submit" class="btn btn-primary float-end">Add</button>
        </div>
    </form>
</div>
@endsection