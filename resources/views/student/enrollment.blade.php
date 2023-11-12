@extends('student.components.layout')

@section('content')
<div class="row py-3">
    <h1 class="mb-3">Enrollment</h1>
    <div class="container-xl">
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
        <form action="studentenrollment" id="enrollmentForm" method="POST">
            @csrf
            <div class="form-outline mb-3">
                <input type="text" class="form-control" id="strand" value="{{$getstrand->strand}}" readonly required>
                <label class="form-label" for="lastNameInput">Strand</label>
            </div>

            <label for="yearlevel" class="form-label">Year Level:</label>
            <div class="input-group mb-3">
                <select name="yearlevel" id="yearlevel" class="form-select" required>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>


            <label for="schoolyear" class="form-label">School Year:</label>
            <div class="input-group mb-2">
                <select name="schoolyear" id="schoolyear" class="form-select" required>

                </select>
            </div>

            <label for="yearlevel" class="form-label">Semester:</label>
            <div class="input-group mb-3">
                <select name="semester" id="semester" class="form-select" required>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                </select>
            </div>

            <div id="sectiondiv" hidden>
                <label for="yearlevel" class="form-label">Section:</label>
                <div class="input-group mb-3">
                    <select name="section" id="section" class="form-select" required>

                    </select>
                </div>
            </div>

            <button class="btn btn-primary float-end" data-bs-toggle="modal"
                data-bs-target="#addeditmodal">Confirm</button>
        </form>

        <div id="subjectscontainer" class=" pt-4" hidden>
            <h5>Subjects</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><strong>Subjects</strong></th>
                        <th scope="col"><strong>Start</strong></th>
                        <th scope="col"><strong>End</strong></th>
                        <th scope="col"><strong>Day</strong></th>
                        <th scope="col"><strong>Teacher</strong></th>
                    </tr>
                </thead>
                <tbody id="subjects">

                </tbody>
            </table>
        </div>

    </div>
</div>


<div class="modal fade" id="addeditmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addeditmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addeditmodalLabel">
                    <div>Confirm Selection</div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Warning</h4>
                <p>
                    After you pressed confirm you will be enrolled to this Section.
                </p>

                <hr>
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <a class="btn btn-primary" id="passed">Confirm</a>
                        <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('jsscripts')
<script>
    $(document).ready(function(){
        var currentYear = new Date().getFullYear();

        for (var year = currentYear + 1; year >= currentYear-2; year--) {
            $('#schoolyear').append('<option value="' + year + '-' + (year + 1) + '">' + year + '-' + (year + 1) + '</option>');
        }

        $('#yearlevel, #schoolyear, #semester').change(function(){
            handleSelectChanges();
        })

        $('#enrollmentForm').on('submit', function(event) {

            event.preventDefault();

        });

        $('#passed').on('click', function () {
            // Trigger form submission when the confirm button in the modal is clicked
            $('#enrollmentForm').off('submit').submit();
        });

        function handleSelectChanges(){
            let yearlevel = $('#yearlevel').val();
            let schoolyear = $('#schoolyear').val();
            let semester = $('#semester').val();
            let strand = $('#strand').val();

            $('#subjects').empty();
            $.get('/enrollSection', {
                yearlevel: yearlevel,
                schoolyear: schoolyear,
                semester: semester,
                strand: strand
            }, function(data){
                // var sections = data.sections;

                console.log(data);

                $('#section').empty();
                $('#section').append('<option value="" hidden selected>Select Section</option');
                data.forEach(function(data){
                    $('#section').append('<option value="'+data.id+'">'+data.name+'</option');
                })

            })

            $('#sectiondiv').removeAttr('hidden');
            $('#subjectscontainer').removeAttr('hidden');
        }

        $('#section').change(function(){
            sectionfind();
        })

        function sectionfind(){
            let section = $('#section').val();

            $.get('/fetschSchedule', {
                section:section,
            }, function(data){
                data.forEach(function(data){
                    let tablerow = '<tr>' +
                        '<th scope="row"><strong>'+ data.subject +'</strong></th>' +
                        '<th scope="row"><strong>'+ data.startTime +'</strong></th>' +
                        '<th scope="row"><strong>'+ data.endTime +'</strong></th>' +
                        '<th scope="row"><strong>'+ data.day +'</strong></th>' +
                        '<th scope="row"><strong>'+ data.teacher['firstname'] + ' ' + data.teacher['middlename'] + ' ' + data.teacher['lastname'] +'</strong></th>' +
                        '</tr>';

                    $('#subjects').append(tablerow);
                })
            })
        }
    })
</script>
@endpush