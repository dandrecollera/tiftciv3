@extends('admin.components.modal')

@section('style')
<style>
    label {
        font-size: 14px;
        font-weight: 500;
    }

    .was-validated .form-control:valid {
        margin-bottom: 0;
    }

    .was-validated .form-control:invalid {
        margin-bottom: 0;
    }
</style>
@endsection


@section('content')
<div style="padding: 0px 20px 0px 10px">
    <form action="/adminstudent_add_process" method="POST" target="_parent" enctype="multipart/form-data"
        class="was-validated">
        @csrf
        <div class="container-fluid">

            <div class="input-group mt-2 mb-2">
                <div class="form-outline">
                    <input type="text" class="form-control" name="email" id="emailInput" required>
                    <label for="emailInput" class="form-label">Email:</label>
                </div>
                <div class="form-outline">
                    <input type="text" class="form-control is-valid" value="@tiftci.org" readonly>
                </div>
            </div>

            <div class="form-outline mt-4 mb-2">
                <input type="number" class="form-control" name="lrn" id="lrn" maxlength="12" min="0"
                    data-mdb-showcounter="true" type="number" pattern="/^-?\d+\.?\d*$/"
                    onKeyPress="if(this.value.length==12) return false;" required>
                <label for="lrn" class="form-label">Learner Reference Number:</label>
                <div class="form-helper"></div>
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

            <label for="strand" class="form-label">Strand:</label>
            <div class="input-group mb-3">
                <select name="strand" id="strand" class="form-select">
                    <option selected hidden value="">Strand</option>
                    <option value="ABM">ABM</option>
                    <option value="HE">HE</option>
                    <option value="ICT">ICT</option>
                    <option value="GAS">GAS</option>
                </select>
            </div>

            <label for="yearlevel" class="form-label">Year Level:</label>
            <div class="input-group mb-3">
                <select name="yearlevel" id="yearlevel" class="form-select">
                    <option value="" selected hidden>Year Level</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>


            <div id="sectionhide" hidden>
                <label for="section" class="form-label">Section:</label>
                <div class="input-group mb-3">
                    <select name="section" id="section" class="form-select">

                    </select>
                </div>
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
    $('#yearlevel, #strand').change(function() {
        $('#sectionhide').removeAttr('hidden');
        var value1 = $('#yearlevel').val();
        var value2 = $('#strand').val();
        $.get('/getSections/' + encodeURIComponent(value1) + '/' + encodeURIComponent(value2), function(data) {
            var options = '';
            $.each(data, function(key, value) {
                options += '<option value="' + key + '">' + value  +'</option>';
            });
            $('#section').html(options);
        });
    });
});
</script>

@endpush