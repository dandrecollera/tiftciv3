{{-- blade-formatter-disable --}}
@extends('student.components.layout')

@section('content')

<h1>Grades</h1>

<div class="container-lg mt-4">
    <div class="input-group">
        @php
        $year = request()->input('year');
        $currentUrl = url()->current();
        @endphp

        <button class="btn btn-warning dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ empty($year) ? $latestyearstudent->schoolyear : $year }}
        </button>
        <ul class="dropdown-menu">
            @foreach ($allyear as $singyear)
            @php

            $yearUrl = $currentUrl . "?year={$singyear}";
            if (!empty($day)) {
            $yearUrl .= "&day={$day}";
            }
            @endphp
            <li><a class="dropdown-item" href="{{ $yearUrl }}">{{ $singyear }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body overflow-scroll">
                    <h4 class="card-subtitle mb-2 "><strong>1st Semester</strong></h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><strong>Types</strong></th>
                                <th><strong>Learning Area</strong></th>
                                <th><strong>1st</strong></th>
                                <th><strong>2nd</strong></th>
                                <th><strong>Semestral Final Grade</strong></th>
                                <th><strong>Remarks</strong></th>
                                <th><strong>Action Take</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($first as $fgrades)
                            <tr>
                                <th><strong></strong></th>
                                <th><strong>{{$fgrades['subject']}}</strong></th>
                                <td>
                                    <strong>
                                        {{$fgrades['1st']}}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{$fgrades['2nd']}}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{$fgrades['ave']}}
                                    </strong>
                                </td>
                                <td>
                                    {{$fgrades['remarks']}}
                                </td>
                                <td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body overflow-scroll">
                    <h4 class="card-subtitle mb-2 "><strong>2nd Semester</strong></h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><strong>Types</strong></th>
                                <th><strong>Learning Area</strong></th>
                                <th><strong>3rd</strong></th>
                                <th><strong>4th</strong></th>
                                <th><strong>Semestral Final Grade</strong></th>
                                <th><strong>Remarks</strong></th>
                                <th><strong>Action Take</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($second as $sgrades)
                            <tr>
                                <th><strong></strong></th>
                                <th><strong>{{$sgrades['subject']}}</strong></th>
                                <td>
                                    <strong>
                                        {{$sgrades['1st']}}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{$sgrades['2nd']}}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{$sgrades['ave']}}
                                    </strong>
                                </td>
                                <td>
                                    {{$sgrades['remarks']}}
                                </td>
                                <td>
                                </td>
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