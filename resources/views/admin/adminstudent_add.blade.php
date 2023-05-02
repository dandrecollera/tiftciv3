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
    <form action="/adminstudent_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <label for="emailInput" class="form-label">Email:</label>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" id="emailInput" required>
            </div>

            <label class="form-label">Password: (8 Characters Long)</label>
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

            <label class="form-label">Name:</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstNameInput"
                    required>
                <input type="text" class="form-control" placeholder="Middle Name" name="middlename"
                    id="middleNameInput">
                <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastNameInput"
                    required>
            </div>

            <label for="mobilenumber" class="form-label">Contact Number:</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Contact Number" name="mobilenumber"
                    id="contactInput">
            </div>

            <label for="address" class="form-label">Address:</label>
            <div class="input-group mb-3">
                <textarea class="form-control" name="address" id="addressInput" rows="3"
                    placeholder="Address"></textarea>
            </div>

            <label for="address" class="form-label">Section:</label>
            <div class="input-group mb-3">
                <select name="section" id="statusInput" class="form-select">
                    @foreach ($sections as $section)
                    <option value="{{$section->id}}" selected>{{$section->id}}: {{$section->section_name}}</option>
                    @endforeach
                </select>
            </div>

            <label for="address" class="form-label">Status:</label>
            <div class="input-group mb-3">
                <select name="status" id="statusInput" class="form-select">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <label for="InputGroupFile01" class="form-label">Image:</label>
            <div class="input-group mb-3">
                <input type="file" name="image" class="form-control" id="inputGroupFile01">
            </div>

            <button type="submit" class="btn btn-primary float-end">Save</button>
        </div>
    </form>
</div>
@endsection