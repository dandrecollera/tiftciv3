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
    <form action="/adminteacher_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <div class="form-outline mt-2 mb-2">
                <input type="email" class="form-control" name="email" id="emailInput" required>
                <label for="emailInput" class="form-label">Email:</label>
            </div>

            <div class="row" id="conpass">
                <div class="pb-1">
                    <span id="textExample2" class="form-text"> Must be 8-20 characters long. </span>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <a id="show1" href="#conpass" style="color: inherit;"><i
                                class="fas fa-eye-slash trailing pe-auto" id="eye1"></i></a>
                        <input name="password" type="password" class="form-control" id="password"
                            data-mdb-showcounter="true" maxlength="20" required>
                        <label class="form-label" for="password">Password</label>
                        <div class="form-helper"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <a id="show2" href="#conpass" style="color: inherit;"><i
                                class="fas fa-eye-slash trailing pe-auto" id="eye2"></i></a>
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
                <input maxlength="11" min="0" data-mdb-showcounter="true" type="number" pattern="/^-?\d+\.?\d*$/"
                    onKeyPress="if(this.value.length==11) return false;" class="form-control" name="mobilenumber"
                    onkeydown="return event.keyCode !== 69 && event.keyCode !== 187" id="contactInput"
                    value="{{ !empty($dbdata->mobilenumber) ? $dbdata->mobilenumber : '' }}">
                <label class="form-label" for="contactInput">Mobile Number</label>
                <div class="form-helper"></div>
            </div>

            <div class="form-outline mt-4 mb-2">
                <textarea class="form-control" name="address" id="address" rows="4"></textarea>
                <label class="form-label" for="address">Address</label>
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
                <input type="file" name="image" class="form-control" id="inputGroupFile01"
                    accept="image/jpeg,image/png">
            </div>

            <button type="submit" class="btn btn-primary float-end ripple">Save</button>
        </div>
    </form>
</div>
@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function(){

    $('#show1').on('click', function() {
        if($('#password').attr('type') == "text"){
            $('#password').attr('type', 'password');
            $('#eye1').addClass( "fa-eye-slash" );
            $('#eye1').removeClass( "fa-eye" );
        } else{
            $('#password').attr('type', 'text');
            $('#eye1').addClass( "fa-eye" );
            $('#eye1').removeClass( "fa-eye-slash" );
        }
    });
    $('#show2').on('click', function() {
        if($('#password2').attr('type') == "text"){
            $('#password2').attr('type', 'password');
            $('#eye2').addClass( "fa-eye-slash" );
            $('#eye2').removeClass( "fa-eye" );
        } else{
            $('#password2').attr('type', 'text');
            $('#eye2').addClass( "fa-eye" );
            $('#eye2').removeClass( "fa-eye-slash" );
        }
    });
});
</script>

@endpush