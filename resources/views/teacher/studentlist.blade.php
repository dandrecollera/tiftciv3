@extends('teacher.components.layout')

@section('content')
<h2>Student List</h2>
<div class="row py-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $lastsection = 999;
                            @endphp
                            @foreach ($sections as $section)
                            @if ($section->sectionid != $lastsection)
                            <tr>
                                <td colspan="3"><strong>{{$section->section_name}}</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a class="btn btn-dark btn-sm" href="#"
                                        data-bs-target="#subjectTeacher{{$section->sectionid}}"
                                        data-bs-toggle="collapse" data-bs-target="#addeditmodal"><i
                                            class="fa-solid fa-caret-down fa-xs"></i></a>
                                </td>
                            </tr>
                            <tr id="subjectTeacher{{$section->sectionid}}" class="collapse">
                                <td colspan="8">
                                    <iframe id="" src="/students?sid={{$section->sectionid}}" width="100%"
                                        height="500px" style="border:none;"></iframe>
                                </td>
                            </tr>
                            @endif
                            @php
                            $lastsection = $section->sectionid;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection