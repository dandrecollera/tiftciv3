@php
$path = request()->path();
@endphp

<a href="/portal" class="list-group-item list-group-item-spec  py-2 ripple {{$path == 'portal' ? 'active' : ''}}">
    <i class="fas fa-table-columns fa-fw me-3" style="{{$path == 'portal' ? 'color:#2D58A1;' : ''
        }}"></i><span>Home</span>
</a>

<br>
<h5>Information</h5>
<a href="/grades" class="list-group-item list-group-item-spec py-2 ripple {{$path == 'grades' ? 'active' : ''}}">
    <i class="fas fa-star fa-fw me-3" style="{{$path == 'grades' ? 'color:#2D58A1;' : ''
        }}"></i><span>Grades</span>
</a>

<a href="/schedule" class="list-group-item list-group-item-spec py-2 ripple {{$path == 'schedule' ? 'active' : ''}}">
    <i class="fas fa-calendar fa-fw me-3" style="{{$path == 'schedule' ? 'color:#2D58A1;' : ''
        }}"></i><span>Schedule</span>
</a>

<a href="/balance" class="list-group-item list-group-item-spec py-2 ripple {{$path == 'balance' ? 'active' : ''}}">
    <i class="fas fa-peso-sign fa-fw me-3" style="{{$path == 'balance' ? 'color:#2D58A1;' : ''
        }}"></i><span>Balance</span>
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

<br>
<h5>Other</h5>
<a href="/studentappointment"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'studentappointment' ? 'active' : ''}}">
    <i class="fas fa-comment fa-fw me-3" style="{{$path == 'studentappointment' ? 'color:#2D58A1;' : ''
        }}"></i><span>Appointment</span>
    @if ($seenstatus > 0)
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-danger overflow-visible"
        style="z-index:3;">
        {{$seenstatus}}
    </span>
    @endif
</a>

<a href="/enrollment"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'enrollment' ? 'active' : ''}}">
    <i class="fas fa-file fa-fw me-3" style="{{$path == 'enrollment' ? 'color:#2D58A1;' : ''
        }}"></i><span>Enrollment</span>
</a>

<a href="https://tiftci.com/?"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'lms' ? 'active' : ''}}">
    <i class="fas fa-laptop fa-fw me-3" style="{{$path == 'lms' ? 'color:#2D58A1;' : ''
        }}"></i><span>Student LMS</span>
</a>
