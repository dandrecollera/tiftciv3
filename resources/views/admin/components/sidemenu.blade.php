@php
$path = request()->path();
@endphp

<a href="/admin" class="list-group-item list-group-item-dark py-2 {{$path == 'admin' ? 'active' : ''}}">
    <span>Dashboard</span>
</a>

<a href="#"
    class="list-group-item list-group-item-dark dropdown-toggle navbar-toggler py-2 {{$path == 'adminteacher' || $path == 'adminuser' ? 'active' : ''}}"
    data-bs-toggle="collapse" data-bs-target="#AdminToolsContent" role="button">
    <span>Accounts</span>
</a>
<div class="collapse list-group-flush ps-2" id="AdminToolsContent">
    <a href="/adminuser" class="list-group-item list-group-item-dark py-2 {{$path == 'adminuser' ? 'active' : ''}}">
        <span>Administrator</span>
    </a>
    <a href="/adminteacher"
        class="list-group-item list-group-item-dark py-2 {{$path == 'adminteacher' ? 'active' : ''}}">
        <span>Teachers</span>
    </a>
</div>

<a href="/adminsubject" class="list-group-item list-group-item-dark py-2 {{$path == 'adminsubject' ? 'active' : ''}}">
    <span>Subjects</span>
</a>

<a href="/adminsection" class="list-group-item list-group-item-dark py-2 {{$path == 'adminsection' ? 'active' : ''}}">
    <span>Sections</span>
</a>

<a href="/adminschoolyear"
    class="list-group-item list-group-item-dark py-2 {{$path == 'adminschoolyear' ? 'active' : ''}}">
    <span>School Year</span>
</a>

<a href="/adminstudent" class="list-group-item list-group-item-dark py-2 {{$path == 'adminstudent' ? 'active' : ''}}">
    <span>Students</span>
</a>

<a href="/adminappointments"
    class="list-group-item list-group-item-dark py-2 {{$path == 'adminappointments' ? 'active' : ''}}">
    <span>Appointments</span>
</a>