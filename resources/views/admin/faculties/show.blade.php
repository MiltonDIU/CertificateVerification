@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.faculty.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.faculties.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.id') }}
                        </th>
                        <td>
                            {{ $faculty->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.name') }}
                        </th>
                        <td>
                            {{ $faculty->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.slug') }}
                        </th>
                        <td>
                            {{ $faculty->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Faculty::IS_ACTIVE_SELECT[$faculty->is_active] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.faculties.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#faculty_programs" role="tab" data-toggle="tab">
                    {{ trans('cruds.program.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#faculty_students" role="tab" data-toggle="tab">
                    {{ trans('cruds.student.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="faculty_programs">
                @includeIf('admin.faculties.relationships.facultyPrograms', ['programs' => $faculty->facultyPrograms])
            </div>
            <div class="tab-pane" role="tabpanel" id="faculty_students">
                @includeIf('admin.faculties.relationships.facultyStudents', ['students' => $faculty->facultyStudents])
            </div>
        </div>
    </div>

@endsection
