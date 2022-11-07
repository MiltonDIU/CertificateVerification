@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.convocation.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.convocations.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.id') }}
                        </th>
                        <td>
                            {{ $convocation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.name') }}
                        </th>
                        <td>
                            {{ $convocation->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.slug') }}
                        </th>
                        <td>
                            {{ $convocation->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.controller_of_examination') }}
                        </th>
                        <td>
                            {{ $convocation->controller_of_examination }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.controller_of_examination_signature') }}
                        </th>
                        <td>
                            @if($convocation->controller_of_examination_signature)
                                <a href="{{ $convocation->controller_of_examination_signature->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $convocation->controller_of_examination_signature->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.vice_chancellor') }}
                        </th>
                        <td>
                            {{ $convocation->vice_chancellor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.vice_chancellor_signature') }}
                        </th>
                        <td>
                            @if($convocation->vice_chancellor_signature)
                                <a href="{{ $convocation->vice_chancellor_signature->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $convocation->vice_chancellor_signature->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.convocation.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Convocation::IS_ACTIVE_SELECT[$convocation->is_active] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.convocations.index') }}">
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
                <a class="nav-link" href="#convocation_students" role="tab" data-toggle="tab">
                    {{ trans('cruds.student.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="convocation_students">
                @includeIf('admin.convocations.relationships.convocationStudents', ['students' => $convocation->convocationStudents])
            </div>
        </div>
    </div>

@endsection
