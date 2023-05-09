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

<br>
<h5>Other</h5>
<a href="/hmv"
    class="list-group-item list-group-item-spec py-2 ripple d-flex flex-row align-items-center {{$path == 'hmv' ? 'active' : ''}}">
    <div>
        <i class="fas fa-monument fa-fw me-3" style="vertical-align: middle;{{$path == 'hmv' ? 'color:#2D58A1;' : ''
    }}"></i>
    </div>
    <div>
        History, Mission & Vision
    </div>
</a>

<a href="/feedback" class="list-group-item list-group-item-spec py-2 ripple {{$path == 'feedback' ? 'active' : ''}}">
    <i class="fas fa-comment fa-fw me-3" style="{{$path == 'feedback' ? 'color:#2D58A1;' : ''
        }}"></i><span>Feedback</span>
</a>

<a href="https://tiftci.com/?"
    class="list-group-item list-group-item-spec py-2 ripple {{$path == 'lms' ? 'active' : ''}}">
    <i class="fas fa-laptop fa-fw me-3" style="{{$path == 'lms' ? 'color:#2D58A1;' : ''
        }}"></i><span>Student LMS</span>
</a>

{{-- <a href="/about" class="list-group-item list-group-item-warning py-2">
    <span>About</span>
</a>

<a href="/FAQs" class="list-group-item list-group-item-warning py-2">
    <span>FAQs</span>
</a> --}}