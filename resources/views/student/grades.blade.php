@extends('student.components.layout')

@section('content')

<h1>Grades</h1>



<div class="container-lg mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">2022-2023</h5>
                    <h6 class="card-subtitle mb-2 text-muted">1st Semester</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Subjects</th>
                                <th>1st</th>
                                <th>2nd</th>
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
                                <th>{{ $subject->subject_name }}</th>
                                <td>
                                    @if ($firstQuarterGrade)
                                    {{$firstQuarterGrade}}
                                    @else
                                    0
                                    @endif
                                </td>
                                <td>
                                    @if ($secondQuarterGrade)
                                    {{$secondQuarterGrade}}
                                    @else
                                    0
                                    @endif
                                </td>
                            </tr>
                            @php
                            $lastsubjectid = $subject->subjectid;
                            @endphp
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <h6 class="card-subtitle mb-2 text-muted">2nd Semester</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Subjects</th>
                                <th>3rd</th>
                                <th>4th</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                            @if ($subject->semester == '2nd' && $subject->subjectid != $lastsubjectid)
                            @php
                            $grades = DB::table('grades')
                            ->where('subjectid', $subject->subjectid)
                            ->where('studentid', $userinfo[0])
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
                                <th>{{ $subject->subject_name }}</th>
                                <td>
                                    @if ($firstQuarterGrade)
                                    {{$firstQuarterGrade}}
                                    @else
                                    0
                                    @endif
                                </td>
                                <td>
                                    @if ($secondQuarterGrade)
                                    {{$secondQuarterGrade}}
                                    @else
                                    0
                                    @endif
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
</div>


@endsection