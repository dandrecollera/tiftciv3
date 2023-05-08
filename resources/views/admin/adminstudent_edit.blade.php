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
    <form action="/adminstudent_edit_process" method="POST" target="_parent">
        @csrf
        <div class="container-fluid mb-4">

            <h4>Edit Student Details</h4>
            <div class="form-outline my-4">
                <input type="email" class="form-control" name="email" id="emailInput" value="{{$dbdata->email}}"
                    readonly disabled>
                <label for="emailInput" class="form-label">Email:</label>
            </div>

            <div class="input-group my-4">
                <div class="form-outline">
                    <input type="text" class="form-control" name="firstname" id="firstNameInput"
                        value="{{$dbdata->firstname}}" required>
                    <label class="form-label" for="firstNameInput">First Name</label>
                </div>
                <div class="form-outline">
                    <input type="text" class="form-control" name="middlename" id="middleNameInput"
                        value="{{ !empty($dbdata->middlename) ? $dbdata->middlename : '' }}">
                    <label class="form-label overflow-x-scroll pe-2" for="middleNameInput">Middle Name</label>
                </div>
                <div class="form-outline">
                    <input type="text" class="form-control" name="lastname" id="lastNameInput"
                        value="{{$dbdata->lastname}}" required>
                    <label class="form-label" for="lastNameInput">Last Name</label>
                </div>
            </div>

            <div class="form-outline my-4">
                <input type="text" class="form-control" name="mobilenumber" id="contactInput"
                    value="{{ !empty($dbdata->mobilenumber) ? $dbdata->mobilenumber : '' }}">
                <label class="form-label" for="contactInput">Mobile Number</label>
            </div>

            <div class="form-outline mt-4 mb-2">
                <textarea class="form-control" name="address" id="address"
                    rows="4">{{ !empty($dbdata->address) ? $dbdata->address : '' }}</textarea>
                <label class="form-label" for="address">Address</label>
            </div>

            <label for="address" class="form-label">Status:</label>
            <div class="input-group mb-3">
                <select name="status" id="statusInput" class="form-select">
                    <option value="active" {{ $dbdata->status == 'active' ? 'selected' : ''}}>Active</option>
                    <option value="inactive" {{$dbdata->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                </select>
            </div>

            <input type="hidden" name="did" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>
            <br>
        </div>
    </form>

    <hr>

    <form action="/adminstudent_section_process" method="POST" target="_parent">
        @csrf
        <div class="container-fluid mb-4">
            <h4>Change Section</h4>
            <label for="address" class="form-label">Section:</label>
            <div class="input-group mb-3">
                <select name="section" id="statusInput" class="form-select">
                    @foreach ($sections as $section)
                    <option value="{{$section->id}}" {{$dbdata->section_name == $section->section_name ? 'selected' :
                        ''}}>{{$section->id}}: {{$section->section_name}}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="did" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>
            <br>
        </div>
    </form>


    <hr>

    <form action="/adminstudent_pass_process" method="POST" target="_parent">
        @csrf
        <div class="container-fluid mb-4">

            <h4>Change Password</h4>
            <label class=" form-label">Password: (8 Characters Long)</label>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <input name="password2" type="password" class="form-control" placeholder="Retype Password"
                            required>
                    </div>
                </div>
            </div>
            <input type="hidden" name="did" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>
            <br>
        </div>
    </form>


    <hr>

    <form action="/adminstudent_image_process" method="post" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <h4>Update Profile Picture</h4>

            <label for="InputGroupFile01" class="form-label">Image: <span>{{ $dbdata->photo }}</span></label>
            <div class="input-group mb-3">
                <input type="file" name="image" class="form-control" id="inputGroupFile01">
            </div>

            <input type="hidden" name="did" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>

        </div>
    </form>

</div>
@endsection