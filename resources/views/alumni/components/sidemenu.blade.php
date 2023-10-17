@php
$path = request()->path();
@endphp

<a href="/portal" class="list-group-item list-group-item-spec  py-2 ripple {{$path == 'portal' ? 'active' : ''}}">
    <i class="fas fa-table-columns fa-fw me-3" style="{{$path == 'portal' ? 'color:#2D58A1;' : ''
        }}"></i><span>Home</span>
</a>



@php
$seenstatus = DB::table('appointments')
->where('email', '=', $userinfo[4])
->where(function ($query) {
$query->where('active', '=', 'Approved')
->orWhere('active', '=', 'Declined')
->orWhere('active', '=', 'Completed');
})
->where('seen', '=', 0)
->count();
@endphp




