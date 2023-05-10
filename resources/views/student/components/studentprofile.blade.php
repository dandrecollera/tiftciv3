@extends('student.components.layout')

@section('content')
@php
$dbdata = DB::table('main_users')
->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
->where('main_users.id', $userinfo[0])
->first();
@endphp

<div class="row mb-4 mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex flex-column">
                <center>
                    <img src="{{ asset('/storage/images/'.$userinfo[6])}}" class="rounded-circle me-lg-0 me-2 dpcover"
                        height="150" width="150" alt=""
                        style="border-style: solid; border-color: rgba(189, 189, 189, 0.651); border-width: 2px;"
                        loading="lazy" />
                </center>
                <div class="container-lg">
                    <div class="form-outline my-4">
                        <input type="email" class="form-control" name="email" id="emailInput" value="{{$dbdata->email}}"
                            readonly disabled>
                        <label for="emailInput" class="form-label">Email:</label>
                    </div>

                    <div class="input-group my-4">

                        <div class="form-outline">
                            <input type="text" class="form-control" name="firstname" id="firstNameInput"
                                value="{{$dbdata->firstname}}" readonly disabled>
                            <label class="form-label" for="firstNameInput">First Name</label>
                        </div>
                        <div class="form-outline">
                            <input type="text" class="form-control" name="middlename" id="middleNameInput"
                                value="{{ !empty($dbdata->middlename) ? $dbdata->middlename : '' }}" readonly disabled>
                            <label class="form-label overflow-x-scroll pe-2" for="middleNameInput">Middle
                                Name</label>
                        </div>
                        <div class="form-outline">
                            <input type="text" class="form-control" name="lastname" id="lastNameInput"
                                value="{{$dbdata->lastname}}" readonly disabled>
                            <label class="form-label" for="lastNameInput">Last Name</label>
                        </div>
                    </div>

                    <div class="form-outline my-4">
                        <input type="text" class="form-control" name="mobilenumber" id="contactInput"
                            value="{{ !empty($dbdata->mobilenumber) ? $dbdata->mobilenumber : '' }}" readonly disabled>
                        <label class="form-label" for="contactInput">Mobile Number</label>
                    </div>

                    <div class="form-outline mt-4 mb-2">
                        <textarea class="form-control" name="address" id="address" rows="4" readonly
                            disabled>{{ !empty($dbdata->address) ? $dbdata->address : '' }}</textarea>
                        <label class="form-label" for="address">Address</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>







@endsection