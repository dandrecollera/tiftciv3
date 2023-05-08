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

            <div class="form-outline mt-2 mb-2">
                <input type="email" class="form-control" name="email" id="emailInput" required>
                <label for="emailInput" class="form-label">Email:</label>
            </div>

            <div class="row">
                <div class="pb-1">
                    <span id="textExample2" class="form-text"> Must be 8-20 characters long. </span>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <input name="password" type="password" class="form-control" id="password"
                            data-mdb-showcounter="true" maxlength="20" required>
                        <label class="form-label" for="password">Password</label>
                        <div class="form-helper"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <input name="password2" type="password" class="form-control" id="password2"
                            data-mdb-showcounter="true" maxlength="20" required>
                        <label class="form-label" for="password2">Retype Password</label>
                        <div class="form-helper"></div>
                    </div>
                </div>
            </div>

            <div class="input-group my-4 pt-2">
                <div class="form-outline">
                    <input type="text" class="form-control" name="firstname" id="firstNameInput" required>
                    <label class="form-label" for="firstNameInput">First Name</label>
                </div>
                <div class="form-outline">
                    <input type="text" class="form-control" name="middlename" id="middleNameInput">
                    <label class="form-label overflow-x-scroll pe-2" for="middleNameInput">Middle Name</label>
                </div>
                <div class="form-outline">
                    <input type="text" class="form-control" name="lastname" id="lastNameInput" required>
                    <label class="form-label" for="lastNameInput">Last Name</label>
                </div>
            </div>

            <div class="form-outline my-4">
                <input type="text" class="form-control" name="mobilenumber" id="contactInput">
                <label class="form-label" for="contactInput">Mobile Number</label>
            </div>

            <div class="form-outline mt-4 mb-2">
                <textarea class="form-control" name="address" id="address" rows="4"></textarea>
                <label class="form-label" for="address">Address</label>
            </div>

            <label for="address" class="form-label">Section:</label>
            <div class="input-group mb-3">
                <select name="section" id="statusInput" class="form-select">
                    @foreach ($sections as $section)
                    <option value="{{$section->id}}">{{$section->id}}: {{$section->section_name}}</option>
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

            <hr>

            <label for="address" class="form-label">Payment Type:</label>
            <div class="input-group mb-3">
                <select name="paymenttype" id="statusInput" class="form-select">
                    <option value="public" selected>Public School</option>
                    <option value="semi">Private School-Esc & Non-Esc Grante</option>
                    <option value="private">Private School</option>
                </select>
            </div>
            <label for="address" class="form-label">Payment Method:</label>
            <div class="input-group mb-3">
                <select name="paymentmethod" id="statusInput" class="form-select">
                    <option value="full" selected>Full</option>
                    <option value="semesteral">Semestral</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary float-end">Save</button>
        </div>
    </form>
</div>
@endsection