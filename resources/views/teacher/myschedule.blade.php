@extends('teacher.components.layout')

@section('content')

<div class="container-lg mt-2">
    <h1>My Schedule</h1>
    <div class="row ">
        <div class="col-12">
            <div class="row">
            </div>
            <form method="get">
                <div class="input-group mb-3">

                    @php
                    $day = request()->input('day');
                    $year = request()->input('year');
                    $currentUrl = url()->current();
                    @endphp
                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ empty($day) ? "Filter to Day" : "Filter to ".$day }}
                    </button>
                    <ul class="dropdown-menu">
                        @php
                        $dayQuery = empty($year) ? '' : "&year={$year}";
                        @endphp
                        <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Monday{{ $dayQuery }}">Monday</a></li>
                        <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Tuesday{{ $dayQuery }}">Tuesday</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Wednesday{{ $dayQuery }}">Wednesday</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Thursday{{ $dayQuery }}">Thursday</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ $currentUrl }}?day=Friday{{ $dayQuery }}">Friday</a></li>
                    </ul>


                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ empty($year) ? $latestyear->schoolyear : $year }}
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($allyear as $singyear)
                        @php
                        $yearUrl = $currentUrl . "?year={$singyear->schoolyear}";
                        if (!empty($day)) {
                        $yearUrl .= "&day={$day}";
                        }
                        @endphp
                        <li><a class="dropdown-item" href="{{ $yearUrl }}">{{ $singyear->schoolyear }}</a></li>
                        @endforeach
                    </ul>

                    <a href="/teacherschedulepdf?year={{ empty($year) ? $latestyear->schoolyear : $year }}"
                        class="btn btn-info shadow-sm btn-sm float-end" target="_blank">Schedule List</a>

                    @if (!empty($day) || !empty($year))
                    @php
                    $currentUrl = url()->current();
                    $query = request()->getQueryString();
                    @endphp
                    <a class="btn btn-dark" href="{{ $currentUrl }}" role="button"><i
                            class="fas fa-search fa-rotate fa-sm"></i></a>
                    @endif
                </div>
            </form>
            <div class="card ">
                <div class="card-body overflow-scroll">
                    @php
                    $day = request('day');
                    @endphp
                    <h5 class="card-title">{{$day ? $day.' Schedule' : 'Week Schedule'}}</h5>
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col"><strong>Sections</strong></th>
                                <th scope="col"><strong>Start</strong></th>
                                <th scope="col"><strong>End</strong></th>
                                <th scope="col"><strong>Day</strong></th>
                                <th scope="col"><strong>Subjects</strong></th>
                            </tr>
                        </thead>
                        <tbody id="newschedcont">
                            @foreach ($teacherschedule as $schedule)

                            <tr>
                                <th scope="row"><strong>{{$schedule['section']}}</strong></th>
                                <td>{{$schedule['startTime']}}</td>
                                <td>{{$schedule['endTime']}}</td>
                                <td>{{$schedule['day']}}</td>
                                <td>{{$schedule['subject']}}</td>
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

@push('jsscripts')

@endpush
