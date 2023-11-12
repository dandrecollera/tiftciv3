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
    <form action="/adminrealcurriculum_edit_process" method="POST" target="_parent" enctype="multipart/form-data"
        class="was-validated">
        @csrf
        <div class="container-fluid">

            <div class="form-outline">
                <input type="text" class="form-control" name="name" id="name" value="{{$curriculum->name}}" required>
                <label for="name" class="form-label">Curriculum Name:</label>
            </div>

            <label for="address" class="form-label">School Year:</label>
            <div class="input-group mb-3">
                <select name="schoolyear" id="schoolyear" class="form-select">
                </select>
            </div>

            <label for="semester" class="form-label">Year Level:</label>
            <div class="input-group mb-4">
                <select name="yearlevel" id="yearlevel" class="form-select">
                    <option value="11" {{$curriculum->yearlevel == "11" ? 'selected' : ''}}>11</option>
                    <option value="12" {{$curriculum->yearlevel == "12" ? 'selected' : ''}}>12</option>
                </select>
            </div>

            <label for="strand" class="form-label">Strand:</label>
            <div class="input-group mb-2">
                <select name="strand" id="strand" class="form-select">
                    <option value="ABM" {{$curriculum->strand == "ABM" ? 'selected' : ''}}>ABM</option>
                    <option value="HE" {{$curriculum->strand == "HE" ? 'selected' : ''}}>HE</option>
                    <option value="ICT" {{$curriculum->strand == "ICT" ? 'selected' : ''}}>ICT</option>
                    <option value="GAS" {{$curriculum->strand == "GAS" ? 'selected' : ''}}>GAS</option>
                </select>
            </div>

            <label for="semester" class="form-label">Semester:</label>
            <div class="input-group mb-4">
                <select name="semester" id="semester" class="form-select">
                    <option value="1st" {{$curriculum->semester == "1st" ? 'selected' : ''}}>1st</option>
                    <option value="2nd" {{$curriculum->semester == "2nd" ? 'selected' : ''}}>2nd</option>
                </select>
            </div>



            <h3>Subjects</h3>


            <table class="table table-hover" id="curriculumTable">
                <thead>
                    <tr>
                        <th scope="col">Subject</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $csttArray = json_decode($curriculum->cstt, true);

                    $allsubjects = DB::table('subjects')
                    ->get()
                    ->toArray();

                    $allteachers = DB::table('main_users')
                    ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
                    ->where('accounttype', 'teacher')
                    ->get()
                    ->toArray();
                    @endphp

                    @if (is_array($csttArray))
                    @foreach ($csttArray as $row)
                    <tr>
                        <td>
                            <div class="input-group mb-3">
                                <select name="subject[]" class="form-select subject" required>
                                    @foreach ($allsubjects as $sub)
                                    <option value="{{ $sub->id }}" {{ $sub->id == $row['subjectid'] ? 'selected' : ''
                                        }}>
                                        {{ $sub->subject_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-xs"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" id="addRow">Add Row</button>
                </div>
                <input type="hidden" value="{{$curriculum->id}}" name="sid">
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

        // fetchOptions('/fetchSubjects', 'subject');
        // fetchOptions('/fetchTeachers', 'teacher');
        var currentYear = new Date().getFullYear();

        for (var year = currentYear + 1; year >= 2020; year--) {
    var value = year + '-' + (year + 1);
    var selected = value === '{{$curriculum->schoolyear}}' ? 'selected' : '';

    $('#schoolyear').append('<option value="' + value + '" ' + selected + '>' + value + '</option>');
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