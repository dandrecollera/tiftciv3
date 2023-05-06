@php
$path = request()->path();
@endphp

<a href="/teacher" class="list-group-item list-group-item-info py-2 {{$path == 'teacher' ? 'active' : ''}}">
    <span>Home</span>
</a>