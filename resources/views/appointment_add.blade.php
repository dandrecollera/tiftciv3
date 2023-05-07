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

@php
$sections = DB::table('sections')
->get()
->toArray();
@endphp


<div style="padding: 0px 20px 0px 10px">
    <form action="/appointment_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <label for="emailInput" class="form-label">Email</label>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="sectionname" id="sectionInput"
                    required>
            </div>
            <label for="emailInput" class="form-label">Name</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="First Name" name="sectionname" id="sectionInput"
                    required>
                <input type="text" class="form-control" placeholder="Middle Name" name="sectionname" id="sectionInput">
                <input type="text" class="form-control" placeholder="Last Name" name="sectionname" id="sectionInput"
                    required>
            </div>
            <label for="emailInput" class="form-label">Mobile Number</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Mobile Number" name="sectionname" id="sectionInput"
                    required>
            </div>

            <label for="address" class="form-label">Address:</label>
            <div class="input-group mb-3">
                <textarea class="form-control" name="address" id="addressInput" rows="3"
                    placeholder="Address"></textarea>
            </div>

            <label for="address" class="form-label">Graduate:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="yesGrad" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="noGrad" id="inlineRadio2" value="option2">
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>

            <br><br>
            <label for="emailInput" class="form-label">Section</label>
            <div class="input-group mb-3">
                <select name="strand" id="strandInput" class="form-select" required>
                    @foreach ($sections as $section)
                    <option value="{{$section->id}}">{{$section->section_name}}</option>
                    @endforeach
                </select>
            </div>


            <label class="form-label">Type of Inquiry</label>
            <div class="input-group mb-3">
                <select name="yearlevel" id="inquiry" class="form-select" required>
                    <option value="Enrollment" selected>Enrollment</option>
                    <option value="Document Request">Document Request</option>
                </select>
            </div>

            <div id="documentstuff" hidden>
                <label for="address" class="form-label">Documents</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio1"
                        value="option1">
                    <label class="form-check-label" for="inlineRadio1">Good Moral</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio2"
                        value="option2">
                    <label class="form-check-label" for="inlineRadio2">F137</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio2"
                        value="option2">
                    <label class="form-check-label" for="inlineRadio2">F138</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio2"
                        value="option2">
                    <label class="form-check-label" for="inlineRadio2">Diploma</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio2"
                        value="option2">
                    <label class="form-check-label" for="inlineRadio2">Others</label>
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
        // Hide the documentstuff div by default
        $('#documentstuff').attr('hidden', true);

        // When the inquiry select element value changes
        $('#inquiry').change(function() {
            // If the value is Document Request
            if ($(this).val() == 'Document Request') {
                // Show the documentstuff div
                $('#documentstuff').removeAttr('hidden');
            } else {
                // Otherwise, hide the documentstuff div
                $('#documentstuff').attr('hidden', true);
            }
        });
    });
</script>
@endpush