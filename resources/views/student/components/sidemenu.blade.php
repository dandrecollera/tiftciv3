@php
$path = request()->path();
@endphp

<a href="/portal" class="list-group-item list-group-item-warning py-2 {{$path == 'portal' ? 'active' : ''}}">
    <span>Home</span>
</a>

<br>
<h5>Information</h5>
<a href="/grades" class="list-group-item list-group-item-warning py-2 {{$path == 'grades' ? 'active' : ''}}">
    <span>Grades</span>
</a>

<a href="/schedule" class="list-group-item list-group-item-warning py-2 {{$path == 'schedule' ? 'active' : ''}}">
    <span>Schedule</span>
</a>

<a href="/balance" class="list-group-item list-group-item-warning py-2 {{$path == 'balance' ? 'active' : ''}}">
    <span>Balance</span>
</a>

<br>
<h5>Other</h5>
<a href="/hmv" class="list-group-item list-group-item-warning py-2 {{$path == 'hmv' ? 'active' : ''}}">
    <span>History, Mission & Vision</span>
</a>

<a href="/feedback" class="list-group-item list-group-item-warning py-2 {{$path == 'feedback' ? 'active' : ''}}">
    <span>Feedback</span>
</a>

<a href="https://tiftci.com/?"
    class="list-group-item list-group-item-warning py-2 {{$path == 'teacher' ? 'active' : ''}}">
    <span>Student LMS</span>
</a>

{{-- <a href="/about" class="list-group-item list-group-item-warning py-2">
    <span>About</span>
</a>

<a href="/FAQs" class="list-group-item list-group-item-warning py-2">
    <span>FAQs</span>
</a> --}}