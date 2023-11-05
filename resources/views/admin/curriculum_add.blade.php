@extends('admin.components.modal')

@section('style')
<style>
    label {
        font-size: 14px;
        font-weight: 500;
    }

    .was-validated .form-control:valid {
        margin-bottom: 0;
    }

    .was-validated .form-control:invalid {
        margin-bottom: 0;
    }
</style>
@endsection


@section('content')
<div style="padding: 0px 20px 0px 10px">
    <form action="/admincurriculum_add_process" method="POST" target="_parent" enctype="multipart/form-data"
        class="was-validated">
        @csrf
        <div class="container-fluid">

            <div class="form-outline">
                <input type="text" class="form-control" name="name" id="name" required>
                <label for="name" class="form-label">Curriculum Name:</label>
            </div>

            <label for="address" class="form-label">School Year:</label>
            <div class="input-group mb-2">
                <select name="schoolyear" id="schoolyear" class="form-select">

                </select>
            </div>

            <label for="yearlevel" class="form-label">Year Level:</label>
            <div class="input-group mb-2">
                <select name="yearlevel" id="yearlevel" class="form-select">
                    <option value="11">11</option>
                    <option value="12">12</option>

                </select>
            </div>


            <label for="strand" class="form-label">Strand:</label>
            <div class="input-group mb-2">
                <select name="strand" id="strand" class="form-select">
                    <option value="ABM">ABM</option>
                    <option value="HE">HE</option>
                    <option value="ICT">ICT</option>
                    <option value="GAS">GAS</option>
                </select>
            </div>

            <label for="semester" class="form-label">Semester:</label>
            <div class="input-group mb-4">
                <select name="semester" id="semester" class="form-select">
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                </select>
            </div>

            <h3>Subjects</h3>

            <table class="table table-hover" id="curriculumTable">
                <thead>
                    <tr>
                        <th scope="col">Subject</th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Time</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="input-group mb-3">
                                <select name="subject[]" id="" class="form-select subject" required>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <select name="teacher[]" id="" class="form-select teacher" required>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <select name="day[]" id="" class="form-select day" required>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <input type="time" name="starttime[]" class="form-control" required>
                                <input type="time" name="endtime[]" class="form-control" required>
                            </div>
                        </td>

                        <td>
                            <a class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-xs"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" id="addRow">Add Row</button>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-primary float-end">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function () {

        fetchOptions('/fetchSubjects', 'subject');
        fetchOptions('/fetchTeachers', 'teacher');
        var currentYear = new Date().getFullYear();

        for (var year = currentYear + 1; year >= 2020; year--) {
            $('#schoolyear').append('<option value="' + year + '-' + (year + 1) + '">' + year + '-' + (year + 1) + '</option>');
        }

        $('#addRow').click(function () {
            var newRow = $('#curriculumTable tbody tr:first').clone();
            newRow.find('select,input').val('');
            newRow.find('a.btn-danger').click(removeRow); // Add click event for delete button
            $('#curriculumTable tbody').append(newRow);
        });

        $('#curriculumTable tbody').on('click', 'a.btn-danger', removeRow);

        // Function to remove the corresponding row when delete button is clicked
        function removeRow() {
            $(this).closest('tr').remove();
        }

        function fetchOptions(url, elementId) {
            $.get(url, function (data) {
                populateDropdown(elementId, data);
            });
        }

        function populateDropdown(elementId, data) {
            var dropdown = $('.' + elementId);
            dropdown.empty();

            $.each(data, function (index, item) {
                var value, text;

                if (item.hasOwnProperty('subject_name')) {
                    value = item.id;
                    text = item.subject_name.trim();
                } else if (item.hasOwnProperty('lastname')) {
                    var fullName = item.firstname + ' ' + item.middlename + ' ' + item.lastname;
                    value = item.id;
                    text = fullName.trim();
                } else {
                    value = index;
                    text = 'Unknown';
                }

                dropdown.append($('<option>', {
                    value: value,
                    text: text
                }));
            });
        }
    });
</script>

@endpush
