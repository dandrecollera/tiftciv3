@extends('teacher.components.modal')

@section('style')
<style>
    body {
        background: rgba(236, 236, 236, 0);
    }

    label {
        font-size: 14px;
        font-weight: 500;
    }

    * {
        scrollbar-width: auto;
        scrollbar-color: rgba(0, 0, 0, 0.2) rgba(0, 0, 0, 0.2);
    }

    /* Chrome, Edge, and Safari */
    ::-webkit-scrollbar {
        width: 2px;
        height: 2px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.0);
    }
</style>
@endsection

@section('content')
<div class="py-3 px-5">
    <a href="studentlistpdf?id={{$section->id}}" class="btn btn-dark shadow-sm btn-sm float-end"
        style="margin-right: 10px;" target="_blank">Student
        List</a>

    <h4>{{ $section->name }} Students</h4>
    <hr>
    <div class="row fs-6">
        <div class="col overflow-scroll scrollable-container mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th><strong>Email</strong></th>
                        <th><strong>LRN</strong></th>
                        <th><strong>Name</strong></th>
                        <th><strong>Contact No.</strong></th>
                        <th colspan="4"><strong>Address</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dbresult as $dbr)
                    <tr>
                        <th><img src="{{ asset('/storage/images/' . $dbr->photo) }}"
                                class="rounded-circle me-lg-0 me-2 dpcover" height="40" width="40" alt=""
                                loading="lazy" /></th>
                        <th><strong>{{$dbr->email}}</strong></th>
                        <th>{{$dbr->lrn}}</th>
                        <th>{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}</th>
                        <th>{{$dbr->mobilenumber}}</th>
                        <th colspan="4">{{$dbr->address}}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
