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
    <form action="/adminstudent_edit_process" method="POST" target="_parent">
        @csrf
        <div class="container-fluid mb-4">

            <h4>Edit Student Details</h4>
            <div class="form-outline mt-2 mb-4">
                <input type="text" class="form-control" name="email" id="emailInput"
                    value="{{ explode('@', $dbdata->email)[0] }}" required>
                <label for=" emailInput" class="form-label">Username:</label>
            </div>

            <div class="form-outline my-4">
                <input type="text" class="form-control" name="empty" id="empty" value="{{ $dbdata->email}}" readonly>
                <label for=" emailInput" class="form-label">Email:</label>
            </div>

            <div class="form-outline mt-4 mb-2">
                <input type="number" class="form-control" name="lrn" id="lrn" maxlength="12" min="0"
                    data-mdb-showcounter="true" type="number" pattern="/^-?\d+\.?\d*$/"
                    onKeyPress="if(this.value.length==12) return false;" value="{{$dbdata->lrn}}" required>
                <label for="lrn" class="form-label">Learner Reference Number:</label>
                <div class="form-helper"></div>
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
                <input maxlength="11" min="0" data-mdb-showcounter="true" type="number" pattern="/^-?\d+\.?\d*$/"
                    onKeyPress="if(this.value.length==11) return false;" class="form-control" name="mobilenumber"
                    onkeydown="return event.keyCode !== 69 && event.keyCode !== 187" id="contactInput"
                    value="{{ !empty($dbdata->mobilenumber) ? $dbdata->mobilenumber : '' }}">
                <label class="form-label" for="contactInput">Mobile Number</label>
                <div class="form-helper"></div>
            </div>

            <div class="form-outline mt-4 mb-2">
                <textarea class="form-control" name="address" id="address"
                    rows="4">{{ !empty($dbdata->address) ? $dbdata->address : '' }}</textarea>
                <label class="form-label" for="address">Address</label>
            </div>

            {{-- <label for="address" class="form-label">Status:</label>
            <div class="input-group mb-3">
                <select name="status" id="statusInput" class="form-select">
                    <option value="active" {{ $dbdata->status == 'active' ? 'selected' : ''}}>Active</option>
                    <option value="inactive" {{$dbdata->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                </select>
            </div> --}}

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

            <label for="strand" class="form-label">Strand:</label>
            <div class="input-group mb-3">
                <select name="strand" id="strand" class="form-select">
                    <option value="ABM" {{ $dbdata->strand == 'ABM' ? 'selected' : ''}}>ABM</option>
                    <option value="HE" {{ $dbdata->strand == 'HE' ? 'selected' : ''}}>HE</option>
                    <option value="ICT" {{ $dbdata->strand == 'ICT' ? 'selected' : ''}}>ICT</option>
                    <option value="GAS" {{ $dbdata->strand == 'GAS' ? 'selected' : ''}}>GAS</option>
                </select>
            </div>

            <label for="yearlevel" class="form-label">Year Level:</label>
            <div class="input-group mb-3">
                <select name="yearlevel" id="yearlevel" class="form-select">
                    <option value="11" {{ $dbdata->yearlevel == '11' ? 'selected' : ''}}>11</option>
                    <option value="12" {{ $dbdata->yearlevel == '12' ? 'selected' : ''}}>12</option>
                </select>
            </div>

            <label for="schoolyear" class="form-label">School Year:</label>
            <div class="input-group mb-2">
                <select name="schoolyear" id="schoolyear" class="form-select">

                </select>
            </div>

            <label for="semester" class="form-label">Semester:</label>
            <div class="input-group mb-2">
                <select name="semester" id="semester" class="form-select">
                    <option value="1st" {{ $dbdata->semester == '1st' ? 'selected' : ''}}>1st</option>
                    <option value="2nd" {{ $dbdata->semester == '2nd' ? 'selected' : ''}}>2nd</option>
                </select>
            </div>

            @php
            $current = DB::table('students')
            ->where('userid', $dbdata->id)
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->orderBy('students.id', 'desc')
            ->select('sections.section_name', 'sections.id')
            ->first();

            @endphp
            <label for="section" class="form-label">Section:</label>
            <div class="input-group mb-3">
                <select name="section" id="section" class="form-select">
                    @foreach ($sections as $section)
                    <option value="{{$section->id}}">{{$section->name}}</option>
                    @endforeach
                    {{-- <option value="{{$current->id}}">{{ $current->section_name }}</option> --}}
                </select>
            </div>

            <input type="hidden" name="did" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>
            <br>
        </div>
    </form>


    <hr>

    <form action="/adminstudent_pass_process" method="POST" target="_parent" id="conpass">
        @csrf
        <div class="container-fluid mb-4">

            <h4>Change Password</h4>
            <div class="row mt-4 mb-4">
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

            <div class="input-group mt-3 mb-3">
                <input type="file" name="image" class="form-control" id="inputGroupFile01"
                    accept="image/jpeg,image/png">
            </div>

            <input type="hidden" name="did" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>

        </div>
    </form>

</div>
@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function(){

    var currentYear = new Date().getFullYear();

    for (var year = currentYear + 1; year >= 2020; year--) {
        var value = year + '-' + (year + 1);
        var selected = value === '{{$dbdata->schoolyear}}' ? 'selected' : '';

        $('#schoolyear').append('<option value="' + value + '" ' + selected + '>' + value + '</option>');
    }

    $('#emailInput').keyup(function(){
        $('#empty').val($('#emailInput').val() + '@tiftci.org');
    })

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
    $('#yearlevel, #strand, #schoolyear, #semester').change(function() {
        $('#sectionhide').removeAttr('hidden');
        var value1 = $('#yearlevel').val();
        var value2 = $('#strand').val();
        var value3 = $('#schoolyear').val();
        var value4 = $('#semester').val();
        $.get('/getSections/' + encodeURIComponent(value1) + '/' + encodeURIComponent(value2) + '/' + encodeURIComponent(value3) + '/' + encodeURIComponent(value4), function(data) {
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