@extends('alumni.components.layout')

@section('content')
<h1>Feedback</h1>
<button type="button" id="addbutton" class="btn btn-success btn-sm"><i class="fa-solid fa-circle-plus"></i>Add
    Feedback</button>
<hr>
<div class="container-lg mt-4">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Appointed</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Pending</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection