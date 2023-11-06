@extends('teacher.components.layout')

@section('content')
<div class="container-xl">
    <div class="row">
        <a href="grading">
            <button type="button" class="btn btn-primary mb-2">Back</button>
        </a>
        <h1 class="mb-3">{{$subject->subject_name}}: {{$section->name}}</h1>
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


        <input type="hidden" value="{{$subject->id}}" id="subid">
        <input type="hidden" value="{{$section->id}}" id="secid">
        <div class="row">
            <div class="col overflow-scroll scrollable-container mb-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><strong>Name</strong></th>
                            <th scope="col"><strong>{{$section->semester == '1st' ? '1st' : '3rd'}}</strong></th>
                            <th scope="col"><strong>{{$section->semester == '1st' ? '2nd' : '4th'}}</strong></th>
                            <th scope="col"><strong>Final Grade</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td><strong>{{$student->firstname}} {{$student->lastname}}</strong></td>

                            @php
                            $grade1 = DB::table('grades')
                            ->where('studentid', $student->userid)
                            ->where('subjectid', $subject->id)
                            ->where('sectionid', $section->id)
                            ->where('quarter', $section->semester == '1st' ? '1st' : '3rd')
                            ->first();


                            $grade2 = DB::table('grades')
                            ->where('studentid', $student->userid)
                            ->where('subjectid', $subject->id)
                            ->where('sectionid', $section->id)
                            ->where('quarter', $section->semester == '1st' ? '2nd' : '4th')
                            ->first();

                            @endphp
                            <td>
                                <div class="form-outline" role="group" aria-label="Basic example" style="width: 6em">
                                    <input type="number" class="form-control grade-input"
                                        data-userid="{{$student->userid}}"
                                        data-quarter="{{$section->semester == '1st' ? '1st' : '3rd'}}"
                                        id="gradeinput1st-{{$student->userid}}"
                                        value="{{$grade1 != null ? $grade1->grade : ''}}" required {{$lock !=null
                                        ? 'readonly' : '' }}>
                                    <label for="" class="form-label">Grade</label>
                                    <div class="form-helper"></div>
                                </div>
                            </td>
                            <td>
                                <div class="form-outline" role="group" aria-label="Basic example" style="width: 6em">
                                    <input type="number" class="form-control grade-input"
                                        id="gradeinput2nd-{{$student->userid}}" data-userid="{{$student->userid}}"
                                        data-quarter="{{$section->semester == '1st' ? '2nd' : '4th'}}"
                                        value="{{$grade2 != null ? $grade2->grade : ''}}" required {{$lock !=null
                                        ? 'readonly' : '' }}>
                                    <label for="" class="form-label">Grade</label>
                                    <div class="form-helper"></div>
                                </div>
                            </td>

                            <td>
                                <div class="form-outline" style="width: 6em">

                                    <input type="number" class="form-control" id="gwaInput_{{$student->userid}}" {{$lock
                                        !=null ? 'readonly' : '' }}>
                                </div>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                <div class="" {{$lock !=null ? 'hidden' : '' }}>
                    <button type="button" id="addbutton" class="btn btn-primary shadow-sm btn-sm float-end"
                        data-bs-toggle="modal" data-bs-target="#addeditmodal"> Submit</button>
                </div>
            </div>
        </div>
    </div>
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
                        <a class="btn btn-primary"
                            href="/studentgradeslock?subject={{$subject->id}}&section={{$section->id}}">Confirm</a>
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
    $(document).ready(function() {
        $('.grade-input').on('input', function(){
            let inputvalue = $(this).val();
            let quarter = $(this).data('quarter');
            let userid = $(this).data('userid');
            let id1st = $('#gradeinput1st-' + userid);
            let id2nd = $('#gradeinput2nd-' + userid);
            let gwaInput = $('#gwaInput_' + userid);

            if(inputvalue < 65 || inputvalue > 100){
                gwaInput.val('');
                return;
            }

            saveGrade(userid, $('#subid').val(), $('#secid').val(), inputvalue, quarter)

            let grade1st = parseFloat(id1st.val()) || 0;
            let grade2nd = parseFloat(id2nd.val()) || 0;

            let average = (grade1st + grade2nd) / 2;

            if (grade1st > 0 && grade2nd > 0) {
                // Calculate average
                calculateAndSetAverage(userid, grade1st, grade2nd, gwaInput);
            } else {
                // If only one input has a value or both are empty, clear the average
                gwaInput.val('');
            }

            function calculateAndSetAverage(userid, grade1st, grade2nd, gwaInput) {
                // Calculate average
                let average = (grade1st + grade2nd) / 2;

                // Update the readonly input with the calculated average
                gwaInput.val(average.toFixed(2));
            }
        });

        function saveGrade(studentid, subjectid, sectionid, grade, quarter){
            $.get('/saveGrade', {
                studentid: studentid,
                subjectid: subjectid,
                sectionid: sectionid,
                grade: grade,
                quarter: quarter
            }, function(data) {
                console.log('saved');
            });
        }
        $('.grade-input').trigger('input');
    });
</script>

@endpush
