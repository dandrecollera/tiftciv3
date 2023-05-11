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
$sections = DB::table('sections')
->get()
->toArray();
@endphp


<div style="padding: 0px 20px 0px 10px">
    <form action="/appointment_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Personal Information</h3>

                                <div class="form-outline mt-2 mb-2">
                                    <input type="email" class="form-control" name="email" id="email" required>
                                    <label for="email" class="form-label">Email*</label>
                                </div>

                                <div class="input-group my-4 pt-2">
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="firstname" id="firstname"
                                            required>
                                        <label class="form-label" for="firstname">First Name*</label>
                                    </div>
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="middlename" id="middlename">
                                        <label class="form-label overflow-x-scroll pe-2" for="middlename">Middle
                                            Name</label>
                                    </div>
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                                        <label class="form-label" for="lastname">Last Name*</label>
                                    </div>
                                </div>


                                <div class="form-outline my-4">
                                    <input maxlength="11" min="0" data-mdb-showcounter="true" type="number"
                                        pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;"
                                        class="form-control" name="mobilenumber"
                                        onkeydown="return event.keyCode !== 69 && event.keyCode !== 187"
                                        id="contactInput"
                                        value="{{ !empty($dbdata->mobilenumber) ? $dbdata->mobilenumber : '' }}">
                                    <label class="form-label" for="contactInput">Mobile Number</label>
                                    <div class="form-helper"></div>
                                </div>

                                <div class="form-outline mt-4 mb-2">
                                    <textarea class="form-control" name="address" id="address" rows="4"></textarea>
                                    <label class="form-label" for="address">Address</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">School Information</h3>

                                <label for="graduate" class="form-label">Graduate*</label>
                                <div class="input-group mb-3">
                                    <select name="graduate" id="graduate" class="form-select" required>
                                        <option selected hidden value="">Select Option</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <div id="yearsAttended" hidden>
                                    <label for="lastyearattended" class="form-label" id="labelYearAttended">Last Year
                                        Attended:*</label>
                                    <div class="input-group mb-3">
                                        <select name="lastyearattended" id="lastyearattended" class="form-select"
                                            required>
                                            <option selected hidden value="">Select Option</option>
                                            @php
                                            $currentYear = date('Y');
                                            $startYear = 1990;
                                            @endphp

                                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="form-outline mt-4 mb-2">
                                    <input type="number" class="form-control" name="lrn" id="lrn" maxlength="12" min="0"
                                        data-mdb-showcounter="true" type="number" pattern="/^-?\d+\.?\d*$/"
                                        onKeyPress="if(this.value.length==12) return false;" required>
                                    <label for="lrn" class="form-label">Learner Reference Number:</label>
                                    <div class="form-helper"></div>
                                </div>

                                <label for="emailInput" class="form-label">Strand*</label>
                                <div class="input-group mb-3">
                                    <select name="strand" id="strandInput" class="form-select" required>
                                        <option selected hidden value="">Select Option</option>
                                        <option value="ABM">ABM</option>
                                        <option value="HE">HE</option>
                                        <option value="ICT">ICT</option>
                                        <option value="GAS">GAS</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Inquiry</h3>

                                <label class="form-label">Type of Inquiry*</label>
                                <div class="input-group mb-3">
                                    <select name="inquiry" id="inquiry" class="form-select" required>
                                        <option selected hidden value="">Select Option</option>
                                        <option value="Enrollment">Enrollment</option>
                                        <option value="Document Request">Document Request</option>
                                    </select>
                                </div>

                                <div id="documentstuff" hidden>
                                    <label for="address" class="form-label">Documents</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="goodmoral" id="goodmoral"
                                            value="Good Moral">
                                        <label class="form-check-label" for="goodmoral">Good Moral</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="f137" id="f137"
                                            value="F137">
                                        <label class="form-check-label" for="f137">F137</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="f138" id="f138"
                                            value="F138">
                                        <label class="form-check-label" for="f138">F138</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="diploma" id="diploma"
                                            value="Diploma">
                                        <label class="form-check-label" for="diploma">Diploma</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="others" id="others"
                                            value="Others">
                                        <label class="form-check-label" for="others">Others</label>
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

            <button type="submit" class="btn btn-primary float-end">Submit</button>
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
    });
</script>
@endpush