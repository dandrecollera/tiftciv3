@extends('teacher.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <a href="/section?subject={{$qstring2['subject']}}">
            <button type="button" class="btn btn-primary mb-2">Back</button>
        </a>
        <h1 class="mb-3">
            <div style="font-size: 30px; color: light black;">Grade's Input for</div>
            {{$subject->subject_name}}: {{$section->section_name}}
        </h1>
        <hr>
        @if (!empty($error))
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error</h4>
                    <p>{{ $errorlist[(int) $error ] }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif
        @if (!empty($notif))
        <div class="row">
            <div class="col">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success</h4>
                    <p>{{ $notiflist[(int) $notif ] }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col overflow-scroll scrollable-container mb-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><strong>Name</strong></th>
                            <th scope="col"><strong>{{$subject->semester == "1st" ? '1st' : '3rd'}}</strong></th>
                            <th scope="col"><strong>{{$subject->semester == "1st" ? '2nd' : '4th'}}</strong></th>
                            <th scope="col"><strong> Final Grade</strong></th>
                            <th scope="col"><strong></strong></th> <!-- Add this header for the submit button -->
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $dbr)
                    @php
                    $latestyear = DB::table('schoolyears')
                        ->orderBy('id', 'desc')
                        ->first();

                    $grades = DB::table('grades')
                        ->where('studentid', $dbr->userid)
                        ->where('subjectid', $qstring2['subject'])
                        ->where('yearid', $latestyear->id)
                        ->select('grades.grade', 'grades.quarter', 'grades.id')
                        ->get()
                        ->toArray();

                    $average = '';
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
                        <th scope="row"><strong>{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}</strong></th>
                        <td>
                            @if ($firstQuarterGrade)
                            <a class="topedit" href="#" data-id="{{$dbr->userid}}" data-grade="{{$firstquarterid}}"
                                data-quarter="{{$subject->semester == '1st' ? '1st' : '3rd' }}"
                                data-bs-toggle="modal" data-bs-target="#addeditmodal"
                                data-name="{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}"
                                style="text-decoration: underline">
                                <strong>{{$firstQuarterGrade}}</strong>
                            </a>
                            @else
                            <div class="form-outline" role="group" aria-label="Basic example">
                                <input type="number" class="form-control" id="yourTextInputID_1_{{$dbr->userid}}" min="65" max="100"
                                    oninput="validateInput(this)" required>
                                <label for="yourTextInputID_1_{{$dbr->userid}}" class="form-label">Grade</label>
                                <div class="form-helper"></div>
                            </div>
                            <script>
                                function validateInput(input) {
                                    const inputValue = input.value;
                                    if (inputValue === "100" || (inputValue.length === 1 && inputValue <= 9)) {
                                    } else if (inputValue.length > 2 || inputValue > 100) {
                                        input.value = inputValue.slice(0, 2);
                                    }
                                }
                            </script>     
                            @endif
                        </td>
                        <td>
                            @if ($secondQuarterGrade)
                            <a class="topedit" href="#" data-id="{{$dbr->userid}}" data-grade="{{$secondquarterid}}"
                                data-quarter="{{$subject->semester == '1st' ? '1st' : '3rd' }}"
                                data-bs-toggle="modal" data-bs-target="#addeditmodal"
                                data-name="{{$dbr->firstname}} {{$dbr->middlename}} {{$dbr->lastname}}"
                                style="text-decoration: underline">
                                <strong>{{$secondQuarterGrade}}</strong>
                            </a>
                            @else
                            <div class="form-outline" role="group" aria-label="Basic example">
                                <input type="number" class="form-control" id="yourTextInputID_2_{{$dbr->userid}}" min="65" max="100"
                                    oninput="validateInput(this)" required>
                                <label for="yourTextInputID_2_{{$dbr->userid}}" class="form-label">Grade</label>
                                <div class="form-helper"></div>
                            </div>
                            <script>
                                function validateInput(input) {
                                    const inputValue = input.value;
                                    if (inputValue === "100" || (inputValue.length === 1 && inputValue <= 9)) {
                                    } else if (inputValue.length > 2 || inputValue > 100) {
                                        input.value = inputValue.slice(0, 2);
                                    }
                                }
                            </script>        
                            @endif
                        </td>
                        <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <input type="number" step="0.01" class="form-control" id="gwaInput_{{$dbr->userid}}" readonly style="width: 6em">
                        </div>
                        </td>
                        <td>
                            <button class="btn btn-primary" onclick="calculateAverage({{$dbr->userid}})">Check</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                    <div class="">
                        <button type="button" id="addbutton" class="btn btn-primary shadow-sm btn-sm float-end"
                            data-bs-toggle="modal" data-bs-target="#addeditmodal"> Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function calculateAverage(userId) {
                const firstGrade = parseFloat(document.getElementById(`yourTextInputID_1_${userId}`).value);
                const secondGrade = parseFloat(document.getElementById(`yourTextInputID_2_${userId}`).value);
                if (!isNaN(firstGrade) && !isNaN(secondGrade)) {
                const average = (firstGrade + secondGrade) / 2;
                    document.getElementById(`gwaInput_${userId}`).value = average.toFixed(2);
                }
            }
        </script>
    </div>


<div class="modal fade" id="addeditmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addeditmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addeditmodalLabel">
                    <div>Submission of Grade</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Warning</h4>
                <p>
                    Submiting <strong>the Grades</strong> will finalize the grades for the current year
                </p>

                <hr>
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <a class="btn btn-primary">Confirm</a>
                        <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function(){
    $('.topgrade').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        var names = $(this).data("name");
        console.log(iid);
        $('#addeditmodalLabel').html(names+': {{$subject->semester == "1st" ? '1st Quarter' : '3rd Quarter'}}');
        $('#addeditframe').attr('src', '/studentsgrades_add?id='+iid+'&quarter='+quart+'&{!!$qstring!!}');
    });
    $('.bottomgrade').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        var names = $(this).data("name");
        console.log(iid);
        $('#addeditmodalLabel').html(names+': {{$subject->semester == "1st" ? '2nd Quarter' : '4th Quarter'}}');
        $('#addeditframe').attr('src', '/studentsgrades_add?id='+iid+'&quarter='+quart+'&{!!$qstring!!}');
    });


    $('.topedit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        var grade = $(this).data("grade");
        var names = $(this).data("name");

        console.log(iid);
        $('#addeditmodalLabel').html(names+': {{$subject->semester == "1st" ? '1st Quarter' : '3rd Quarter'}}');
        $('#addeditframe').attr('src', '/studentsgrades_edit?id='+iid+'&quarter='+quart+'&grade='+grade+'&{!!$qstring!!}');
    });
    $('.bottomedit').on('click', function() {
        console.log('edit button clicked!');
        console.log( $(this).data("id") );
        var iid = $(this).data("id");
        var quart = $(this).data("quarter");
        var grade = $(this).data("grade");
        var names = $(this).data("name");

        console.log(iid);
        $('#addeditmodalLabel').html(names+': {{$subject->semester == "1st" ? '2nd Quarter' : '4th Quarter'}}');
        $('#addeditframe').attr('src', '/studentsgrades_edit?id='+iid+'&quarter='+quart+'&grade='+grade+'&{!!$qstring!!}');
    });
});

</script>

@endpush