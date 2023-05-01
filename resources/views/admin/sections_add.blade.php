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
    <form action="/adminsection_add_process" method="POST" target="_parent" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            <label for="emailInput" class="form-label">Section Name</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Section Name" name="sectionname" id="sectionInput"
                    required>
            </div>

            <label for="emailInput" class="form-label">Strand</label>
            <div class="input-group mb-3">
                <select name="strand" id="strandInput" class="form-select" required>
                    <option value="ABM">ABM</option>
                    <option value="HE">HE</option>
                    <option value="ICT">ICT</option>
                    <option value="GAS">GAS</option>
                </select>
            </div>

            <label for="emailInput" class="form-label"></label>
            <div class="input-group mb-3">
                <select name="yearlevel" id="strandInput" class="form-select" required>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary float-end">Add</button>
        </div>
    </form>
</div>
@endsection