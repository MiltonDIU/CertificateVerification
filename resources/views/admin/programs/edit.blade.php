@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.program.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.programs.update", [$program->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="faculty_id">{{ trans('cruds.program.fields.faculty') }}</label>
                    <select class="form-control select2 {{ $errors->has('faculty') ? 'is-invalid' : '' }}" name="faculty_id" id="faculty_id">
                        @foreach($faculties as $id => $entry)
                            <option value="{{ $id }}" {{ (old('faculty_id') ? old('faculty_id') : $program->faculty->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('faculty'))
                        <span class="text-danger">{{ $errors->first('faculty') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.program.fields.faculty_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.program.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $program->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.program.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="slug">{{ trans('cruds.program.fields.slug') }}</label>
                    <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $program->slug) }}">
                    @if($errors->has('slug'))
                        <span class="text-danger">{{ $errors->first('slug') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.program.fields.slug_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.program.fields.is_active') }}</label>
                    <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active" required>
                        <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Program::IS_ACTIVE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', $program->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active'))
                        <span class="text-danger">{{ $errors->first('is_active') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.program.fields.is_active_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection

@push('script')
    <script>
        var convertName2Alias = function () {
            var name = $(this).val().trim().toLowerCase().replace(/\s+/g, '-');
            var slug = $('#slug').val();
            if (slug == '') {
                $('#slug').val(name);
            }
        };
        $(function () {
            $('#name').on('change', convertName2Alias);
        });
    </script>
@endpush
