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

            <label for="emailInput" class="form-label">Teacher</label>
            <div class="input-group mb-3">
                <select name="status" id="statusInput" class="form-select" required>
                    @foreach ($teachers as $teacher)
                    <option value="{{$teacher->id}}">{{ $teacher->firstname}} {{ !empty($teacher->middlename) ?
                        $teacher->middlename : ''}} {{$teacher->lastname}} </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary float-end">Save</button>
        </div>
    </form>
</div>
@endsection