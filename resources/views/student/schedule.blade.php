@extends('student.components.layout')

@section('content')
<h1>Schedule</h1>

<div class="container-lg mt-2">
    <div class="row ">
        <div class="col-12">
            <div class="row">
                <div class="col ">
                    <form method="get">
                        <div class="input-group mb-3">

                            @php
                            $day = request()->input('day');
                            @endphp
                            <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">{{empty($day) ? "Filter to Day"
                                : "Filter to ".$day}}</button>
                            <ul class="dropdown-menu">
                                @php
                                $currentUrl = url()->current();
                                $query = request()->getQueryString();
                                $sid = request()->input('sid');
                                @endphp
                                <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Monday">Monday</a></li>
                                <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Tuesday">Tuesday</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Wednesday">Wednesday</a></li>
                                <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Thursday">Thursday</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Friday">Friday</a></li>
                            </ul>
                            @if (!empty($day))
                            @php
                            $currentUrl = url()->current();
                            $query = request()->getQueryString();

                            @endphp
                            <a class="btn btn-dark" href="{{ $currentUrl }}" role="button"><i
                                    class="fas fa-search fa-rotate fa-sm"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="card ">
                <div class="card-body overflow-scroll">


                    @php
                    $day = request('day');
                    @endphp
                    <h5 class="card-title">Schedule</h5>
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col"><strong>Subjects</strong></th>
                                <th scope="col"><strong>Start</strong></th>
                                <th scope="col"><strong>End</strong></th>
                                <th scope="col"><strong>Day</strong></th>
                                <th scope="col"><strong>Teacher</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newsched as $schedule)
                            <tr>
                                <th scope="row"><strong>{{ $schedule['subject'] }}</strong></th>
                                <th scope="row"><strong>{{ $schedule['startTime'] }}</strong></th>
                                <th scope="row"><strong>{{ $schedule['endTime'] }}</strong></th>
                                <th scope="row"><strong>{{ $schedule['day'] }}</strong></th>
                                <th scope="row"><strong>{{ $schedule['teacher']->firstname }} {{
                                        $schedule['teacher']->middlename }} {{ $schedule['teacher']->lastname
                                        }}</strong>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
