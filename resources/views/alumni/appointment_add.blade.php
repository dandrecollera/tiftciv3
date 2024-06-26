@extends('modal')

@section('style')
<style>
    label {
        font-size: 14px;
        font-weight: 500;
    }
</style>
@endsection


@section('content')

@php
$sections = DB::table('students')
->where('userid', $userinfo[0])
->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
->first();

$myself = DB::table('main_users')
->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
->where('main_users.id', $userinfo[0])
->first();

$currentyear = DB::table('schoolyears')
->orderBy('id', 'desc')
->first();

@endphp


<div style="padding: 0px 20px 0px 10px">
    <form action="/alumniappointment_add_processs" method="POST" target="_parent" enctype="multipart/form-data"
        id="appointmentGo">
        @csrf
        <div class="container-fluid">
            <h1>Appointment</h1>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Personal Information</h3>

                                <div class="form-outline mt-2 mb-2">
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{$myself->email}}" readonly>
                                    <label for="email" class="form-label">Email*</label>
                                </div>

                                <div class="input-group my-4 pt-2">
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="firstname" id="firstname"
                                            value="{{$myself->firstname}}" readonly>
                                        <label class="form-label" for="firstname">First Name*</label>
                                    </div>
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="middlename" id="middlename"
                                            value="{{$myself->middlename}}" readonly>
                                        <label class="form-label overflow-x-scroll pe-2" for="middlename">Middle
                                            Name</label>
                                    </div>
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="lastname" id="lastname"
                                            value="{{$myself->lastname}}" readonly>
                                        <label class="form-label" for="lastname">Last Name*</label>
                                    </div>
                                </div>


                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="{{$myself->mobilenumber}}" readonly>
                                    <label class="form-label" for="mobilenumber">Mobile Number</label>
                                </div>

                                <div class="form-outline mt-4 mb-2">
                                    <textarea class="form-control" name="address" id="address" rows="4"
                                        readonly>{{$myself->address}}</textarea>
                                    <label class="form-label" for="address">Address</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">School Information</h3>

                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="Yes" readonly>
                                    <label class="form-label" for="mobilenumber">Graduate</label>
                                </div>

                                <div class="form-outline mt-4 mb-2">
                                    <input type="number" class="form-control" name="lrn" id="lrn" maxlength="12" min="0"
                                        data-mdb-showcounter="true" type="number" pattern="/^-?\d+\.?\d*$/"
                                        onKeyPress="if(this.value.length==12) return false;" value="{{$myself->lrn}}"
                                        readonly>
                                    <label for="lrn" class="form-label">Learner Reference Number:</label>
                                    <div class="form-helper"></div>
                                </div>


                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="{{$sections->schoolyear}}" readonly>
                                    <label class="form-label" for="mobilenumber">Last School Year Attended</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Document Request</h3>

                                <div>
                                    <label for="address" class="form-label">Documents</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="goodmoral" id="goodmoral"
                                            value="Good Moral">
                                        <label class="form-check-label" for="goodmoral">Good Moral</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="f138" id="f138"
                                            value="F138">
                                        <label class="form-check-label" for="f138">F138</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="registration"
                                            id="Certificate of Registration" value="Certificate of Registration">
                                        <label class="form-check-label" for="Certificate of Registration">Certificate of
                                            Registration</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="others" id="others"
                                            value="Others">
                                        <label class="form-check-label" for="others">Others</label>
                                    </div>

                                    <div>
                                        <label class="form-label">Type of Reason*</label><br>
                                        <div class="input-group mb-3">
                                            <select name="inquiry" id="inquiry" class="form-select" required>
                                                <option selected hidden value="">Select Option</option>
                                                <option value="Scholarship">Scholarship</option>
                                                <option value="Enrollment for College">Enrollment for College</option>
                                            </select>
                                        </div>

                                        <div id="otherdocumentcontainer" hidden>
                                            <div class="form-outline mt-4 mb-4">
                                                <input type="text" class="form-control" name="otherdocument"
                                                    id="otherdocument">
                                                <label for="otherdocument" class="form-label">Other Document:</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-outline mt-4 mb-4">
                                        <input type="text" class="form-control" name="otherreason" id="otherreason">
                                        <label for="otherreason" class="form-label">Additional Reason:</label>
                                    </div>

                                    <div class="form-outline mt-4 mb-4">
                                        <input type="date" id="appointeddate" name="appointeddate" class="form-control"
                                            required>
                                        <label for="appointeddate" class="form-label">Date of Appointment</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary float-end mb-4" id="submitGo">Submit</button>

            </div>
    </form>
</div>
@endsection

@push('jsscripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#documentstuff').attr('hidden', true);
        $('#yearsAttended').attr('hidden', true);
        $('#otherreasoncontainer').attr('hidden', true);

        $('#inquiry').change(function() {
            if ($(this).val() == 'Document Request') {
                $('#documentstuff').removeAttr('hidden');
            } else {
                $('#documentstuff').attr('hidden', true);
            }
        });
        $('#graduate').change(function() {
            if($(this).val() == 'Yes'){
                $('#yearsAttended').removeAttr('hidden');
                $('#labelYearAttended').html('Year Graduated*');
            } else {
                $('#yearsAttended').removeAttr('hidden');
                $('#labelYearAttended').html('Last Year Attended*');
            }
        })
        $('#others').change(function() {
            if($(this).is(':checked')) {

                $('#otherdocumentcontainer').removeAttr('hidden');
            }
            else {
                $('#otherdocumentcontainer').attr('hidden', true);
            }
        })
        $('#submitGo').click(function() {
            $(this).prop('disabled', true);
            $('#appointmentGo').submit();
        })
    });
</script>
@endpush