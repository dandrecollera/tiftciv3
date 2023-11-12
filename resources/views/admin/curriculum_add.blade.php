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

            <div class="form-outline my-3">
                <input type="text" class="form-control" name="name" id="name" required>
                <label for="name" class="form-label">Section Name:</label>
            </div>

            <div class="form-outline my-3">
                <input type="number" class="form-control" name="nostudent" id="nostudent" required>
                <label for="nostudent" class="form-label">No of Student:</label>
            </div>


            <div class="form-outline my-3">
                {{-- <input type="text" class="form-control" name="curr" id="curr" required> --}}
                <label for="name" class="form-label">Curriculum:</label>
                <select name="curr" id="curr" class="form-select" required>
                    <option value="" selected hidden>Curriculum</option>
                    @php
                    $newcurr = DB::table('realcurriculums')
                    ->where('status', 'active')
                    ->get()
                    ->toArray();
                    @endphp
                    @foreach ($newcurr as $curr)
                    <option value="{{$curr->id}}">{{$curr->name}}</option>
                    @endforeach
                </select>
            </div>



            <div id="infocont" hidden>
                <div class="form-outline mb-2">
                    <label for="schoolyear" class="form-label">Section Year:</label>
                    <input type="text" class="form-control" name="schoolyear" id="schoolyear" readonly>
                </div>

                <div class="form-outline mb-2">
                    <label for="yearlevel" class="form-label">Year Level:</label>
                    <input type="text" class="form-control" name="yearlevel" id="yearlevel" readonly>
                </div>

                <div class="form-outline mb-2">
                    <label for="strand" class="form-label">Strand:</label>
                    <input type="text" class="form-control" name="strand" id="strand" readonly>
                </div>


                <div class="form-outline mb-2">
                    <label for="semester" class="form-label">Semester:</label>
                    <input type="text" class="form-control" name="semester" id="semester" readonly>
                </div>




                <h3>Subjects</h3>

                <table class="table table-hover" id="curriculumTable">
                    <thead>
                        <tr>
                            <th scope="col">Subject</th>
                            <th scope="col">Teacher</th>
                            <th scope="col">Day</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">
                        <tr>
                            <td>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control subject" name="subject[]" id="" readonly>
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
            </div>


            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary float-end">Add Section</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('jsscripts')

<script type="text/javascript">
    $(document).ready(function () {
        $('#curr').on('change', function(){
            $('#infocont').removeAttr('hidden');
            $('#tablebody').empty();
            let id = $('#curr').val();
            $.get('/fetchNewCurr', {id: id}, function(data){
                $('#schoolyear').val(data.schoolyear);
                $('#yearlevel').val(data.yearlevel);
                $('#strand').val(data.strand);
                $('#semester').val(data.semester);

                let csttArray = JSON.parse(data.cstt);

                let fetchTeacherPromises = csttArray.map(function (subject) {
                    let newid = subject.subjectid;
                    return new Promise(function (resolve) {
                        $.get('/fetchNewSub', { newid: newid }, function (newdata) {
                            resolve(newdata);
                        });
                    });
                });

            // Wait for all Promises to resolve before proceeding
                Promise.all(fetchTeacherPromises).then(function (teacherDataArray) {
                    // Now, you can iterate over teacherDataArray and populate the dropdowns
                    teacherDataArray.forEach(function (newdata) {
                        let appenddata = "<tr>" +
                                "<td>"+
                                    "<div class='input-group mb-3'>" +
                                        "<input type='hidden' class='form-control subject' name='subject[]' value='"+newdata.id+"' readonly>" +
                                        "<input type='text' class='form-control subject' value='"+newdata.subject_name+"' readonly>" +
                                    "</div>" +
                                "</td>" +
                                "<td>" +
                                    "<div class='input-group mb-3'>" +
                                        "<select name='teacher[]' class='form-select teacher' required>" +
                                        "</select>" +
                                    "</div>" +
                                "</td>" +
                                "<td>" +
                                    "<div class='input-group mb-3'>" +
                                        "<select name='day[]' class='form-select day' required>" +
                                            "<option value='Monday'>Monday</option>" +
                                            "<option value='Tuesday'>Tuesday</option>" +
                                            "<option value='Wednesday'>Wednesday</option>" +
                                            "<option value='Thursday'>Thursday</option>" +
                                            "<option value='Friday'>Friday</option>" +
                                        "</select>" +
                                    "</div>" +
                                "</td>" +
                                "<td>" +
                                    "<div class='input-group mb-3'>" +
                                        "<input type='time' name='starttime[]' class='form-control' required>" +
                                        "<input type='time' name='endtime[]' class='form-control' required>" +
                                    "</div>" +
                                "</td>" +
                            "</tr>";

                            $('#tablebody').append(appenddata);
                    });

                    // Fetch and populate teacher dropdowns
                    fetchOptions('/fetchTeachers', 'teacher');
                });
            });

        })

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