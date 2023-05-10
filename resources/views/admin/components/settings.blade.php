@extends('admin.components.layout')

@section('content')
@php
$dbdata = DB::table('main_users')
->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
->where('main_users.id', $userinfo[0])
->first();
@endphp
@if (!empty($error))
<div class="row">
    <div class="col">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Error</h4>
            <p>{{ $errorlist[(int) $error ] }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
@if (!empty($notif))
<div class="row">
    <div class="col">
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Success</h4>
            <p>{{ $notiflist[(int) $notif ] }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="/adminsetting_edit_process" method="POST" target="_parent">
                    @csrf
                    <div class="container-fluid mb-4">

                        <h4>Edit Admin Details</h4>
                        <div class="form-outline my-4">
                            <input type="email" class="form-control" name="email" id="emailInput"
                                value="{{$dbdata->email}}" readonly disabled>
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
                                <label class="form-label overflow-x-scroll pe-2" for="middleNameInput">Middle
                                    Name</label>
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

                        <input type="hidden" name="did" value="{{ $dbdata->id }}">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </div>
                </form>
                <br>
                <hr>

                <form action="/adminsetting_pass_process" method="POST" target="_parent">
                    @csrf
                    <div class="container-fluid mb-4">

                        <h4>Change Password</h4>
                        <div class="row mt-4 mb-4">
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
                        <input type="hidden" name="did" value="{{ $dbdata->id }}">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                        <br>
                    </div>
                </form>


                <hr>

                <form action="/adminsetting_image_process" method="post" target="_parent" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">

                        <h4>Update Profile Picture</h4>

                        <div class="input-group mt-3 mb-3">
                            <input type="file" name="image" class="form-control" id="inputGroupFile01">
                        </div>

                        <input type="hidden" name="did" value="{{ $dbdata->id }}">
                        <button type="submit" class="btn btn-primary float-end">Save</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>







@endsection