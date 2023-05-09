@php
$path = request()->path();
@endphp

<a href="/teacher" class="list-group-item list-group-item-spec py-2 ripple {{$path == 'teacher' ? 'active' : ''}}">
    <i class="fas fa-table-columns fa-fw me-3" style="{{$path == 'portal' ? 'color:#2D58A1;' : ''
}}"></i>
    <span>Home</span>
</a>

<br>
<h5>Teacher Tools</h5>
<a href="/grading"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'grading' || $path == 'section' || $path == 'studentsgrades' ? 'active' : ''}}">
    <i class="fas fa-star fa-fw me-3" style="{{$path == 'grading' || $path == 'section' || $path == 'studentsgrades' ? 'color:#2D58A1;' : ''
        }}"></i><span>Grading</span>
</a>
<a href="/studentlist"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'studentlist' ? 'active' : ''}}">
    <i class="fas fa-chalkboard-user fa-fw me-3" style="{{$path == 'studentlist' ? 'color:#2D58A1;' : ''
        }}"></i><span>Student List</span>
</a>
<a href="/teacherschedule"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'teacherschedule' ? 'active' : ''}}">
    <i class="fas fa-calendar fa-fw me-3" style="{{$path == 'teacherschedule' ? 'color:#2D58A1;' : ''
        }}"></i><span>My Schedule</span>
</a>