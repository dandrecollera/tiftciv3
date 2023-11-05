@extends('teacher.components.layout')

@section('content')
<h2>Student List</h2>
<div class="row py-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <select name="schoolyear" id="schoolyear" class="form-select mb-3" style="width:25%">
                </select>
                <h4 class="card-title">Sections</h4>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3"><strong>Sections</strong></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="sectionbody">
                            @foreach ($sections as $section)
                            <tr>
                                <td colspan="3"><strong>{{$section->name}}</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a class="btn btn-dark btn-sm" href="#"
                                        data-bs-target="#subjectTeacher{{$section->id}}" data-bs-toggle="collapse"
                                        data-bs-target="#addeditmodal"><i class="fa-solid fa-caret-down fa-xs"></i></a>
                                </td>
                            </tr>
                            <tr id="subjectTeacher{{$section->id}}" class="collapse">
                                <td colspan="8">
                                    <iframe id="" src="/students?sid={{$section->id}}" width="100%" height="500px"
                                        style="border:none;"></iframe>
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

@push('jsscripts')
<script>
    $(document).ready(function(){
        var currentYear = new Date().getFullYear();

        for (var year = currentYear + 1; year >= 2020; year--) {
            $('#schoolyear').append('<option value="' + year + '-' + (year + 1) + '">' + year + '-' + (year + 1) + '</option>');
        }

        $('#schoolyear').change(function(){
            let selectedSchoolYear = $(this).val();

            $.get('/getStudentSection', {schoolyear: selectedSchoolYear}, function(data){
                updateSectionBody(data);
            });
        });

        function updateSectionBody(data){
            let sectionBody = $('#sectionbody');

            sectionBody.empty();

            $.each(data, function(index, section){
                var rowHtml = '<tr>' +
                    '<td colspan="3"><strong>' + section.name + '</strong></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td>' +
                    '<a class="btn btn-dark btn-sm" href="#" ' +
                    'data-bs-target="#subjectTeacher' + section.id + '" ' +
                    'data-bs-toggle="collapse" ' +
                    'data-bs-target="#addeditmodal">' +
                    '<i class="fa-solid fa-caret-down fa-xs"></i>' +
                    '</a>' +
                    '</td>' +
                    '</tr>' +
                    '<tr id="subjectTeacher' + section.id + '" class="collapse">' +
                    '<td colspan="8">' +
                    '<iframe id="" src="/students?sid=' + section.id + '" width="100%" height="500px" style="border:none;"></iframe>' +
                    '</td>' +
                    '</tr>';

                sectionBody.append(rowHtml);
            });


        }
    })
</script>
@endpush
