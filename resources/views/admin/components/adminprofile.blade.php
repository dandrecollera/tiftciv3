@extends('admin.components.layout')

@section('content')
@php
$dbdata = DB::table('main_users')
->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
->where('main_users.id', $userinfo[0])
->first();
@endphp
@if (!empty($error))
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <img src="{{ asset('/storage/images/'.$userinfo[6])}}" class="rounded-circle me-lg-0 me-2 dpcover"
                    height="40" width="40" alt="" loading="lazy" />
            </div>
        </div>
    </div>

</div>
</div>







@endsection