@php
$path = request()->path();
@endphp

<a href="/admin" class="list-group-item list-group-item-spec py-2 ripple {{$path == 'admin' ? 'active' : ''}}">
    <i class="fas fa-table-columns fa-fw me-3" style="{{$path == 'admin' ? 'color:#2D58A1;' : ''
        }}"></i><span>Dashboard</span>
</a>

<a href="#"
    class="list-group-item list-group-item-spec py-2 ripple dropdown-toggle {{$path == 'adminteacher' || $path == 'adminuser' ? 'active' : ''}}"
    data-bs-toggle="collapse" data-bs-target="#AdminToolsContent" role="button">
    <i class="fas fa-users fa-fw me-3" style="{{$path == 'adminteacher' || $path == 'adminuser' ? 'color:#2D58A1;' : ''
        }}"></i><span>Accounts</span>
</a>
<div class="collapse list-group-flush ps-2" id="AdminToolsContent">
    <a href="/adminuser"
        class="list-group-item list-group-item-spec py-2 ripple {{$path == 'adminuser' ? 'active' : ''}}">
        <span>Administrator</span>
    </a>
    <a href="/adminteacher"
        class="list-group-item list-group-item-spec py-2 ripple {{$path == 'adminteacher' ? 'active' : ''}}">
        <span>Teachers</span>
    </a>
</div>

<a href="/adminsubject"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'adminsubject' ? 'active' : ''}}">
    <i class="fas fa-chalkboard fa-fw me-3" style="{{$path == 'adminsubject' ? 'color:#2D58A1;' : ''
        }}"></i><span>Subjects</span>
</a>

<a href="/admincurriculum"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'admincurriculum' ? 'active' : ''}}">
    <i class="fas fa-people-roof fa-fw me-3" style="{{$path == 'admincurriculum' ? 'color:#2D58A1;' : ''
        }}"></i><span>Curriculums</span>
</a>

{{-- <a href="/adminsection"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'adminsection' ? 'active' : ''}}">
    <i class="fas fa-people-roof fa-fw me-3" style="{{$path == 'adminsection' ? 'color:#2D58A1;' : ''
        }}"></i><span>Sections</span>
</a> --}}

{{-- <a href="/adminschoolyear"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'adminschoolyear' ? 'active' : ''}}">
    <i class="fas fa-calendar fa-fw me-3" style="{{$path == 'adminschoolyear' ? 'color:#2D58A1;' : ''
        }}"></i><span>School Year</span>
</a> --}}

<a href="/adminstudent"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'adminstudent' ? 'active' : ''}}">
    <i class="fas fa-chalkboard-user fa-fw me-3" style="{{$path == 'adminstudent' ? 'color:#2D58A1;' : ''
        }}"></i><span>Students</span>
</a>


@php
$seenstatus = DB::table('appointments')->where('active', '=', 'Pending')->where('adminseen', '=', 0)->count();
@endphp

<a href="/adminappointments"
    class="list-group-item list-group-item-spec py-2 ripple d-flex flex-row align-items-center justify-content-betwee {{$path == 'adminappointments' ? 'active' : ''}}">
    <div>
        <i class="fas fa-calendar-check fa-fw me-3"
            style="{{$path == 'adminappointments' ? 'color:#2D58A1;' : ''}}"></i>
    </div>
    <div>
        Appointments
        @if ($seenstatus > 0)
        <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-danger overflow-visible"
            style="z-index:3;">
            {{ $seenstatus }}
        </span>
        @endif
    </div>
</a>




<a href="https://tiftci.org/wp-login.php"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'wordpress' ? 'active' : ''}}">
    <i class="fas fa-brands fa-wordpress fa-fw me-3" style="{{$path == 'wordpress' ? 'color:#2D58A1;' : ''
        }}"></i><span>CMS Public</span>
</a>
