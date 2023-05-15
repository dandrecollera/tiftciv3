{{-- blade-formatter-disable --}}
@extends('student.components.layout')

@section('content')

<h1>Grades</h1>



<div class="container-lg mt-4">

    @php
    $years = DB::table('schoolyears')->orderBy('id', 'desc')->get();

    $getYear = DB::table('tuition')
    ->leftjoin('schoolyears', 'schoolyears.id', '=', 'tuition.yearid')
    ->where('tuition.userid', $userinfo[0])
    ->orderBy('yearid', 'asc')
    ->first();
    $startyear = $getYear->yearid;
    $endyear = $startyear + 1;
    @endphp

    @foreach ($years as $year)

    @if ($year->id == $startyear || $year->id == $endyear)
    @php
    $gradesInYear = DB::table('grades')->where('yearid', $year->id)->get();
    @endphp

    @if ($gradesInYear->count())
    @php
    $availableGrade = DB::table('grades')
    ->where('studentid', $userinfo[0])
    ->where('yearid', $year->id)
    ->select('grades.sectionid')
    ->first();
    $pastSubjects = DB::table('schedules')
    ->where('sectionid', $availableGrade->sectionid)
    ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
    ->get()
    ->toArray();
    @endphp
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title"><strong>{{$year->school_year}}</strong></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><strong>1st Semester</strong></h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><strong>Subjects</strong></th>
                                <th><strong>1st</strong></th>
                                <th><strong>2nd</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $lastsubjectid = 999;
                            @endphp
                            @foreach ($pastSubjects as $subject)
                            @if ($subject->semester == '1st' && $subject->subjectid != $lastsubjectid)

                            @php
                            $grades = DB::table('grades')
                            ->where('subjectid', $subject->subjectid)
                            ->where('studentid', $userinfo[0])
                            ->where('yearid', $year->id)
                            ->select('grades.grade', 'grades.quarter', 'grades.id')
                            ->get()
                            ->toArray();
                            $firstQuarterGrade = '';
                            $secondQuarterGrade = '';
                            $firstquarterid = '';
                            $secondquarterid = '';
                            foreach ($grades as $grade) {
                            if ($grade->quarter == "1st" || $grade->quarter == "3rd") {
                            $firstQuarterGrade = $grade->grade;
                            $firstquarterid = $grade->id;
                            } elseif ($grade->quarter == "2nd" || $grade->quarter == "4th") {
                            $secondQuarterGrade = $grade->grade;
                            $secondquarterid = $grade->id;
                            }
                            }
                            @endphp

                            <tr>
                                <th><strong>{{ $subject->subject_name }}</strong></th>
                                <td>
                                    <strong>
                                        @if ($firstQuarterGrade)
                                        {{$firstQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        @if ($secondQuarterGrade)
                                        {{$secondQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            @php
                            $lastsubjectid = $subject->subjectid;
                            @endphp
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted"><strong>2nd Semester</strong></h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><strong>Subjects</strong></th>
                                <th><strong>3rd</strong></th>
                                <th><strong>4th</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pastSubjects as $subject)
                            @if ($subject->semester == '2nd' && $subject->subjectid != $lastsubjectid)
                            @php
                            $grades = DB::table('grades')
                            ->where('subjectid', $subject->subjectid)
                            ->where('studentid', $userinfo[0])
                            ->where('yearid', $year->id)
                            ->select('grades.grade', 'grades.quarter', 'grades.id')
                            ->get()
                            ->toArray();
                            $firstQuarterGrade = '';
                            $secondQuarterGrade = '';
                            $firstquarterid = '';
                            $secondquarterid = '';
                            foreach ($grades as $grade) {
                            if ($grade->quarter == "1st" || $grade->quarter == "3rd") {
                            $firstQuarterGrade = $grade->grade;
                            $firstquarterid = $grade->id;
                            } elseif ($grade->quarter == "2nd" || $grade->quarter == "4th") {
                            $secondQuarterGrade = $grade->grade;
                            $secondquarterid = $grade->id;
                            }
                            }
                            @endphp

                            <tr>
                                <th><strong>{{ $subject->subject_name }}</strong></th>
                                <td>
                                    <strong>
                                        @if ($firstQuarterGrade)
                                        {{$firstQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        @if ($secondQuarterGrade)
                                        {{$secondQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            @php
                            $lastsubjectid = $subject->subjectid;
                            @endphp
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body overflow-scroll">
                    <h5 class="card-title"><strong>{{$year->school_year}}</strong></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><strong>1st Semester</strong></h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><strong>Subjects</strong></th>
                                <th><strong>1st</strong></th>
                                <th><strong>2nd</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $lastsubjectid = 999;
                            @endphp
                            @foreach ($subjects as $subject)
                            @if ($subject->semester == '1st' && $subject->subjectid != $lastsubjectid)

                            @php
                            $grades = DB::table('grades')
                            ->where('subjectid', $subject->subjectid)
                            ->where('studentid', $userinfo[0])
                            ->where('yearid', $year->id)
                            ->select('grades.grade', 'grades.quarter', 'grades.id')
                            ->get()
                            ->toArray();
                            $firstQuarterGrade = '';
                            $secondQuarterGrade = '';
                            $firstquarterid = '';
                            $secondquarterid = '';
                            foreach ($grades as $grade) {
                            if ($grade->quarter == "1st" || $grade->quarter == "3rd") {
                            $firstQuarterGrade = $grade->grade;
                            $firstquarterid = $grade->id;
                            } elseif ($grade->quarter == "2nd" || $grade->quarter == "4th") {
                            $secondQuarterGrade = $grade->grade;
                            $secondquarterid = $grade->id;
                            }
                            }
                            @endphp

                            <tr>
                                <th><strong>{{ $subject->subject_name }}</strong></th>
                                <td>
                                    <strong>
                                        @if ($firstQuarterGrade)
                                        {{$firstQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        @if ($secondQuarterGrade)
                                        {{$secondQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            @php
                            $lastsubjectid = $subject->subjectid;
                            @endphp
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted"><strong>2nd Semester</strong></h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><strong>Subjects</strong></th>
                                <th><strong>3rd</strong></th>
                                <th><strong>4th</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                            @if ($subject->semester == '2nd' && $subject->subjectid != $lastsubjectid)
                            @php
                            $grades = DB::table('grades')
                            ->where('subjectid', $subject->subjectid)
                            ->where('studentid', $userinfo[0])
                            ->where('yearid', $year->id)
                            ->select('grades.grade', 'grades.quarter', 'grades.id')
                            ->get()
                            ->toArray();
                            $firstQuarterGrade = '';
                            $secondQuarterGrade = '';
                            $firstquarterid = '';
                            $secondquarterid = '';
                            foreach ($grades as $grade) {
                            if ($grade->quarter == "1st" || $grade->quarter == "3rd") {
                            $firstQuarterGrade = $grade->grade;
                            $firstquarterid = $grade->id;
                            } elseif ($grade->quarter == "2nd" || $grade->quarter == "4th") {
                            $secondQuarterGrade = $grade->grade;
                            $secondquarterid = $grade->id;
                            }
                            }
                            @endphp

                            <tr>
                                <th><strong>{{ $subject->subject_name }}</strong></th>
                                <td>
                                    <strong>
                                        @if ($firstQuarterGrade)
                                        {{$firstQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        @if ($secondQuarterGrade)
                                        {{$secondQuarterGrade}}
                                        @else
                                        0
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            @php
                            $lastsubjectid = $subject->subjectid;
                            @endphp
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @endif


    @endif


    @endforeach



</div>


@endsection