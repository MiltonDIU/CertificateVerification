@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.student.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.students.update", [$student->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="serial_no">{{ trans('cruds.student.fields.serial_no') }}</label>
                    <input class="form-control {{ $errors->has('serial_no') ? 'is-invalid' : '' }}" type="text" name="serial_no" id="serial_no" value="{{ old('serial_no', $student->serial_no) }}" required>
                    @if($errors->has('serial_no'))
                        <span class="text-danger">{{ $errors->first('serial_no') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.serial_no_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.student.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="email">{{ trans('cruds.student.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $student->email) }}">
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="student_id_no">{{ trans('cruds.student.fields.student_id_no') }}</label>
                    <input class="form-control {{ $errors->has('student_id_no') ? 'is-invalid' : '' }}" type="text" name="student_id_no" id="student_id_no" value="{{ old('student_id_no', $student->student_id_no) }}" required>
                    @if($errors->has('student_id_no'))
                        <span class="text-danger">{{ $errors->first('student_id_no') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.student_id_no_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="cgpa">{{ trans('cruds.student.fields.cgpa') }}</label>
                    <input class="form-control {{ $errors->has('cgpa') ? 'is-invalid' : '' }}" type="text" name="cgpa" id="cgpa" value="{{ old('cgpa', $student->cgpa) }}" required>
                    @if($errors->has('cgpa'))
                        <span class="text-danger">{{ $errors->first('cgpa') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.cgpa_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="out_of_cgpa">{{ trans('cruds.student.fields.out_of_cgpa') }}</label>
                    <input class="form-control {{ $errors->has('out_of_cgpa') ? 'is-invalid' : '' }}" type="text" name="out_of_cgpa" id="out_of_cgpa" value="{{ old('out_of_cgpa', $student->out_of_cgpa) }}" required>
                    @if($errors->has('out_of_cgpa'))
                        <span class="text-danger">{{ $errors->first('out_of_cgpa') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.out_of_cgpa_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="certificate_generate_day_month">{{ trans('cruds.student.fields.certificate_generate_day_month') }}</label>
                    <input class="form-control {{ $errors->has('certificate_generate_day_month') ? 'is-invalid' : '' }}" type="text" name="certificate_generate_day_month" id="certificate_generate_day_month" value="{{ old('certificate_generate_day_month', $student->certificate_generate_day_month) }}" required>
                    @if($errors->has('certificate_generate_day_month'))
                        <span class="text-danger">{{ $errors->first('certificate_generate_day_month') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.certificate_generate_day_month_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="certificate_generate_year">{{ trans('cruds.student.fields.certificate_generate_year') }}</label>
                    <input class="form-control {{ $errors->has('certificate_generate_year') ? 'is-invalid' : '' }}" type="text" name="certificate_generate_year" id="certificate_generate_year" value="{{ old('certificate_generate_year', $student->certificate_generate_year) }}" required>
                    @if($errors->has('certificate_generate_year'))
                        <span class="text-danger">{{ $errors->first('certificate_generate_year') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.certificate_generate_year_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="result_published_date">{{ trans('cruds.student.fields.result_published_date') }}</label>
                    <input class="form-control {{ $errors->has('result_published_date') ? 'is-invalid' : '' }}" type="text" name="result_published_date" id="result_published_date" value="{{ old('result_published_date', $student->result_published_date) }}" required>
                    @if($errors->has('result_published_date'))
                        <span class="text-danger">{{ $errors->first('result_published_date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.result_published_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="faculty_name">{{ trans('cruds.student.fields.faculty_name') }}</label>
                    <input class="form-control {{ $errors->has('faculty_name') ? 'is-invalid' : '' }}" type="text" name="faculty_name" id="faculty_name" value="{{ old('faculty_name', $student->faculty_name) }}" required>
                    @if($errors->has('faculty_name'))
                        <span class="text-danger">{{ $errors->first('faculty_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.faculty_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="program_name">{{ trans('cruds.student.fields.program_name') }}</label>
                    <input class="form-control {{ $errors->has('program_name') ? 'is-invalid' : '' }}" type="text" name="program_name" id="program_name" value="{{ old('program_name', $student->program_name) }}" required>
                    @if($errors->has('program_name'))
                        <span class="text-danger">{{ $errors->first('program_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.program_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="convocation_name">{{ trans('cruds.student.fields.convocation_name') }}</label>
                    <input class="form-control {{ $errors->has('convocation_name') ? 'is-invalid' : '' }}" type="text" name="convocation_name" id="convocation_name" value="{{ old('convocation_name', $student->convocation_name) }}" required>
                    @if($errors->has('convocation_name'))
                        <span class="text-danger">{{ $errors->first('convocation_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.convocation_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="faculty_id">{{ trans('cruds.student.fields.faculty') }}</label>
                    <select class="form-control select2 {{ $errors->has('faculty') ? 'is-invalid' : '' }}" name="faculty_id" id="faculty_id">
                        @foreach($faculties as $id => $entry)
                            <option value="{{ $id }}" {{ (old('faculty_id') ? old('faculty_id') : $student->faculty->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('faculty'))
                        <span class="text-danger">{{ $errors->first('faculty') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.faculty_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="program_id">{{ trans('cruds.student.fields.program') }}</label>
                    <select class="form-control select2 {{ $errors->has('program') ? 'is-invalid' : '' }}" name="program_id" id="program_id">
                        @foreach($programs as $id => $entry)
                            <option value="{{ $id }}" {{ (old('program_id') ? old('program_id') : $student->program->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('program'))
                        <span class="text-danger">{{ $errors->first('program') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.program_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="convocation_id">{{ trans('cruds.student.fields.convocation') }}</label>
                    <select class="form-control select2 {{ $errors->has('convocation') ? 'is-invalid' : '' }}" name="convocation_id" id="convocation_id">
                        @foreach($convocations as $id => $entry)
                            <option value="{{ $id }}" {{ (old('convocation_id') ? old('convocation_id') : $student->convocation->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('convocation'))
                        <span class="text-danger">{{ $errors->first('convocation') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.student.fields.convocation_helper') }}</span>
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
