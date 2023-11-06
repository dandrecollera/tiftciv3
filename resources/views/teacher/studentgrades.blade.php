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

                            <td>
                                <div class="form-outline" role="group" aria-label="Basic example">
                                    <input type="number" class="form-control grade-input"
                                        data-userid="{{$student->userid}}" id="gradeinput1st-{{$student->userid}}"
                                        required>
                                    <label for="" class="form-label">Grade</label>
                                    <div class="form-helper"></div>
                                </div>
                            </td>
                            <td>
                                <div class="form-outline" role="group" aria-label="Basic example">
                                    <input type="number" class="form-control grade-input"
                                        id="gradeinput2nd-{{$student->userid}}" data-userid="{{$student->userid}}"
                                        required>
                                    <label for="" class="form-label">Grade</label>
                                    <div class="form-helper"></div>
                                </div>
                            </td>

                            <td>
                                <input type="number" step="0.01" class="form-control" id="gwaInput_{{$student->userid}}"
                                    readonly style="width: 6em">
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
    $(document).ready(function() {
    $('.grade-input').on('input', function(){
        let inputvalue = $(this).val();
        let userid = $(this).data('userid');
        let id1st = $('#gradeinput1st-' + userid);
        let id2nd = $('#gradeinput2nd-' + userid);
        let gwaInput = $('#gwaInput_' + userid);

        if(inputvalue < 65 || inputvalue > 100){
            return;
        }

        // Get values from the input fields
        let grade1st = parseFloat(id1st.val()) || 0;
        let grade2nd = parseFloat(id2nd.val()) || 0;

        // Calculate average
        let average = (grade1st + grade2nd) / 2;

        // Update the readonly input with the calculated average
        gwaInput.val(average.toFixed(2));

    })
})
</script>

@endpush
