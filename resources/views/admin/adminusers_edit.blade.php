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
    <form action="/adminuser_edit_process" method="POST" target="_parent">
        @csrf
        <div class="container-fluid mb-4">

            <h4>Edit Details</h4>

            <label for="emailInput" class="form-label">Email:</label>
            <div class="input-group mb-3">
                <input type="email" class="form-control" value="{{ $dbdata->email}}" name="email" id="emailInput"
                    readonly disabled>
            </div>

            <label class="form-label">Name:</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="First Name" value="{{ $dbdata->firstname }}"
                    name="firstname" id="firstNameInput" required>
                <input type="text" class="form-control" placeholder="Middle Name"
                    value="{{ !empty($dbdata->middlename) ? $dbdata->middlename : '' }}" name="middlename"
                    id="middleNameInput" required>
                <input type="text" class="form-control" placeholder="Last Name" value="{{ $dbdata->lastname }}"
                    name="lastname" id="lastNameInput" required>
            </div>

            <label for="mobilenumber" class="form-label">Contact Number:</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Contact Number"
                    value="{{ !empty($dbdata->mobilenumber) ? $dbdata->mobilenumber : '' }}" name="mobilenumber"
                    id="contactInput">
            </div>

            <label for="address" class="form-label">Address:</label>
            <div class="input-group mb-3">
                <textarea class="form-control" name="address" id="addressInput" rows="3"
                    placeholder="Address">{{ !empty($dbdata->address) ? $dbdata->address : '' }}</textarea>
            </div>

            <label for="address" class="form-label">Status:</label>
            <div class="input-group mb-3">
                <select name="status" id="statusInput" class="form-select">
                    <option value="active" {{ $dbdata->status == 'active' ? 'selected' : ''}}>Active</option>
                    <option value="inactive" {{$dbdata->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary float-end">Save</button>
            <br>
        </div>
    </form>

    <hr>

    <form action="/adminuser_pass_process" method="POST" target="_parent">
        @csrf
        <div class="container-fluid mb-4">

            <h4>Change Password</h4>
            <label class=" form-label">Password:</label>
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
            <button type="submit" class="btn btn-primary float-end">Save</button>
            <br>
        </div>
    </form>


    <hr>

    <form action="/adminuser_image_process" method="post" target="_parent" enctype="multipart/form-data">
        <div class="container-fluid">

            <h4>Update Profile Picture</h4>

            <label for="InputGroupFile01" class="form-label">Image:</label>
            <div class="input-group mb-3">
                <input type="file" name="image" class="form-control" id="inputGroupFile01">
            </div>

            <button type="submit" class="btn btn-primary float-end">Save</button>

        </div>
    </form>

</div>
@endsection