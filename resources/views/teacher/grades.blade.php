@extends('teacher.components.layout')

@section('content')
<h1 class="">Grading Portal</h1>
<select name="schoolyear" id="schoolyear" class="form-select mb-3" style="width:25%">
</select>

<h5 class="mb-3">Select a Section to see list of students</h5>
<div class="row" id="card-container">


    @foreach ($compiledCsttData as $subject)

    @php
    // dd($subject);

    $subjectname = DB::table('subjects')
    ->where('id', $subject['subjectid'])
    ->first();
    @endphp
    <div class="col-12 col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title"><strong>{{$subject['section']}}</strong></h6>
                <h6 class="card-title">{{$subjectname->subject_name}} - {{$subject['semester']}} Semester</h6>
                <a href="/studentsgrades?subject={{$subject['subjectid']}}&section={{$subject['curriculumid']}}">
                    <button type="button" class="btn btn-outline-primary btn-sm">Show Students</button>
                </a>
            </div>
        </div>
    </div>
    @endforeach



</div>
@endsection

@push('jsscripts')
<script>
    $(document).ready(function(){
        var currentYear = new Date().getFullYear();

        for (var year = currentYear + 1; year >= 2020; year--) {
            $('#schoolyear').append('<option value="' + year + '-' + (year + 1) + '">' + year + '-' + (year + 1) + '</option>');
        }

        $('#schoolyear').change(function(){
            let selectedSchoolYear = $(this).val();

            $.get('/fetchYearSubject', {schoolyear: selectedSchoolYear}, function(data){
                updatePageContent(data);
            });
        });


        function updatePageContent(updatedData) {
        // Clear existing content
        $('#card-container').empty();

        // Append the updated content
        $.each(updatedData, function (index, subject) {
            // Fetch subject name using AJAX
            $.get('/getSubjectName', { subjectid: subject.subjectid }, function (subjectData) {
                // Append the updated content to the page
                var newContent =
                    '<div class="col-12 col-lg-4 mb-3">' +
                    '<div class="card">' +
                    '<div class="card-body">' +
                        '<h6 class="card-title"><strong>' + subject.section + '</strong></h6>' +
                    '<h6 class="card-title">' + subjectData.subject_name + '- '+  subject.semester +' Semester</h6>' +
                    '<a href="/studentsgrades?subject=' + subject.subjectid + '&section='+ subject.curriculumid +'">' +
                    '<button type="button" class="btn btn-outline-primary btn-sm">Show Students</button>' +
                    '</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                // Append the new content to the row
                $('#card-container').append(newContent);
            });
        });
    }

    })
</script>
@endpush
