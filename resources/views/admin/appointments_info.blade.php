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



<div style="padding: 0px 20px 0px 10px">
    <form action="/studentappointment_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Personal Information</h3>

                                <div class="form-outline mt-2 mb-2">
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{$info->email}}" readonly>
                                    <label for="email" class="form-label">Email*</label>
                                </div>

                                <div class="input-group my-4 pt-2">
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="firstname" id="firstname"
                                            value="{{$info->firstname}}" readonly>
                                        <label class="form-label" for="firstname">First Name*</label>
                                    </div>
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="middlename" id="middlename"
                                            value="{{$info->middlename}}" readonly>
                                        <label class="form-label overflow-x-scroll pe-2" for="middlename">Middle
                                            Name</label>
                                    </div>
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="lastname" id="lastname"
                                            value="{{$info->lastname}}" readonly>
                                        <label class="form-label" for="lastname">Last Name*</label>
                                    </div>
                                </div>


                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="{{$info->mobilenumber}}" readonly>
                                    <label class="form-label" for="mobilenumber">Mobile Number</label>
                                </div>

                                <div class="form-outline mt-4 mb-2">
                                    <textarea class="form-control" name="address" id="address" rows="4"
                                        readonly>{{$info->address}}</textarea>
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
                                        value="{{$info->graduate}}" readonly>
                                    <label class="form-label" for="mobilenumber">Graduate</label>
                                </div>


                                <div class="form-outline mt-4 mb-2">
                                    <input type="number" class="form-control" name="lrn" id="lrn" maxlength="12" min="0"
                                        data-mdb-showcounter="true" type="number" pattern="/^-?\d+\.?\d*$/"
                                        onKeyPress="if(this.value.length==12) return false;" value="{{$info->lrn}}"
                                        readonly>
                                    <label for="lrn" class="form-label">Learner Reference Number:</label>
                                    <div class="form-helper"></div>
                                </div>

                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="{{$info->yearattended}}" readonly>
                                    <label class="form-label" for="mobilenumber">School Year</label>
                                </div>

                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="{{$info->section}}" readonly>
                                    <label class="form-label" for="mobilenumber">Section / Strand </label>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Inquiry</h3>

                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="{{$info->inquiry}}" readonly>
                                    <label class="form-label" for="mobilenumber">Type of Inquiry</label>
                                </div>

                                <div id="documentstuff">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="goodmoral" id="goodmoral"
                                            value="Good Moral" onclick="return false;" {{$info->goodmoral == true ?
                                        'checked' : ''}}>
                                        <label class="form-check-label" for="goodmoral">Good Moral</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="f137" id="f137"
                                            value="F137" onclick="return false;" {{$info->registration == true ?
                                        'checked' :
                                        ''}}>
                                        <label class="form-check-label" for="f137">F137</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="f138" id="f138"
                                            value="F138" onclick="return false;" {{$info->f138 == true ? 'checked'
                                        : ''}}>
                                        <label class="form-check-label" for="f138">F138</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="others" id="others"
                                            value="Others" onclick="return false;" {{$info->others == true ? 'checked'
                                        : ''}}>
                                        <label class="form-check-label" for="others">Others</label>
                                    </div>
                                    @if ($info->others == true)
                                    <div id="otherdocumentcontainer">
                                        <div class="form-outline mt-4 mb-4">
                                            <input type="text" class="form-control" name="otherdocument"
                                                id="otherdocument" value="{{$info->otherdocument}}" readonly>
                                            <label for="otherdocument" class="form-label">Other Document:</label>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="form-outline mt-4 mb-4">
                                    <input type="text" class="form-control" name="otherreason" id="otherreason"
                                        value="{{$info->otherreason}}" readonly>
                                    <label for="otherreason" class="form-label">Additional Reason:</label>
                                </div>



                                <div class="form-outline my-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                        value="{{ date('m/d/Y l', strtotime($info->appointeddate)) }}" readonly>
                                    <label class="form-label" for="mobilenumber">Date of Appointment</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
