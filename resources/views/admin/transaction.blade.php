@extends('admin.components.modal')

@section('style')
<style>
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
    @if (!empty($error))
    <div class="row">
        <div class="col">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Error</h4>
                <p>{{ $errorlist[(int) $error ] }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
    @if (!empty($notif))
    <div class="row">
        <div class="col">
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Success</h4>
                <p>{{ $notiflist[(int) $notif ] }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
    <h4>{{ $schoolyear->school_year }}</h4>
    <h6>{{ $dbresult->firstname }} {{ $dbresult->middlename }} {{ $dbresult->lastname }}</h6>
    <hr>
    <div class="row fs-6">
        <div class="col overflow-scroll scrollable-container mb-2">
            <form action="/admintransaction_deduct_process" method="POST" target="_parent">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Voucher</span>
                    <input type="text" class="form-control" placeholder="Username" value="{{$dbresult->voucher}}"
                        readonly disabled>
                    <input name="voucher" type="text" class="form-control" placeholder="{{ $dbresult->voucher != 0.00 ? 'Enter Amount'
                        : 'Paid' }}" {{ $dbresult->voucher != 0.00 ? "" : ' readonly' }}>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Tuition</span>
                    <input type="text" class="form-control" placeholder="Username" value="{{$dbresult->tuition}}"
                        readonly disabled>
                    <input name="tuition" type="text" class="form-control" placeholder="{{ $dbresult->tuition != 0.00 ? 'Enter Amount'
                        : 'Paid' }}" {{ $dbresult->tuition != 0.00 ? "" : ' readonly' }}>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Registration</span>
                    <input type="text" class="form-control" placeholder="Username" value="{{$dbresult->registration}}"
                        readonly disabled>
                    <input name="registration" type="text" class="form-control" placeholder="{{ $dbresult->registration != 0.00 ?
                    'Enter Amount' :  'Paid' }}" {{ $dbresult->registration != 0.00 ? "" : ' readonly' }}>
                </div>

                <input type="hidden" name="did" value="{{$qsid}}">
                <button type="submit" class="btn btn-primary float-end"
                    onclick="return confirm('Confirm Amount?');">Confirm</button>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="addeditmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addeditmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addeditmodalLabel">
                    <div>Add Teacher</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="addeditframe" src="/subject_teacher_add?sid={{ $qsid }}" width="100%" height="450px"
                    style="border:none; height:80vh;"></iframe>
            </div>

        </div>
    </div>
</div>
@endsection