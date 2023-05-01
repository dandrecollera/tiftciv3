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
    <form action="/adminschedule_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <label for="emailInput" class="form-label">Teacher</label>
            <div class="input-group mb-3">
                <select name="teacher" id="statusInput" class="form-select" required>
                    @foreach ($teachers as $teacher)
                    <option value="{{$teacher->id}}">{{ $teacher->subject_name}}: {{ $teacher->firstname}} {{
                        !empty($teacher->middlename) ?
                        $teacher->middlename : ''}} {{$teacher->lastname}} </option>
                    @endforeach
                </select>
            </div>

            <label for="emailInput" class="form-label">Start Time - End Time:</label>
            <div class="input-group mb-3">
                <input type="time" name="starttime" class="form-control">
                <input type="time" name="endtime" class="form-control">
            </div>

            <label for="emailInput" class="form-label">Day</label>
            <div class="input-group mb-3">
                <select name="day" id="statusInput" class="form-select" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>

            <input type="hidden" name="sid" value="{{ $sid }}">
            <button type="submit" class="btn btn-primary float-end">Add</button>
        </div>
    </form>
</div>
@endsection