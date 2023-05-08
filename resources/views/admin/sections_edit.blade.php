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
    <form action="/adminsection_edit_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">


            <div class="form-outline mt-2 mb-2">
                <input type="text" class="form-control" name="sectionname" id="sectionInput"
                    value="{{ $dbdata->section_name}}" required>
                <label for="sectionInput" class="form-label">Section Name:</label>
            </div>

            <label for="emailInput" class="form-label">Strand</label>
            <div class="input-group mb-3">
                <select name="strand" id="strandInput" class="form-select" required>
                    <option value="ABM" {{ $dbdata->strand == "ABM" ? 'selected' : ''}}>ABM</option>
                    <option value="HE" {{ $dbdata->strand == "HE" ? 'selected' : ''}}>HE</option>
                    <option value="ICT" {{ $dbdata->strand == "ICT" ? 'selected' : ''}}>ICT</option>
                </select>
            </div>

            <label for="emailInput" class="form-label">Year Level</label>
            <div class="input-group mb-3">
                <select name="yearlevel" id="strandInput" class="form-select" required>
                    <option value="11" {{ $dbdata->yearlevel == "11" ? 'selected' : ''}}>11</option>
                    <option value="12" {{ $dbdata->yearlevel == "12" ? 'selected' : ''}}>12</option>
                </select>
            </div>

            <input type="hidden" name="sid" value="{{ $dbdata->id }}">
            <button type="submit" class="btn btn-primary float-end">Save</button>
        </div>
    </form>
</div>
@endsection