@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.program.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.programs.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.program.fields.id') }}
                        </th>
                        <td>
                            {{ $program->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.program.fields.faculty') }}
                        </th>
                        <td>
                            {{ $program->faculty->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.program.fields.name') }}
                        </th>
                        <td>
                            {{ $program->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.program.fields.slug') }}
                        </th>
                        <td>
                            {{ $program->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.program.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Program::IS_ACTIVE_SELECT[$program->is_active] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.programs.index') }}">
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
                <a class="nav-link" href="#program_students" role="tab" data-toggle="tab">
                    {{ trans('cruds.student.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="program_students">
                @includeIf('admin.programs.relationships.programStudents', ['students' => $program->programStudents])
            </div>
        </div>
    </div>

@endsection
