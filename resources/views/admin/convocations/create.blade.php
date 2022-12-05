@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.convocation.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.convocations.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.convocation.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="slug">{{ trans('cruds.convocation.fields.slug') }}</label>
                    <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}">
                    @if($errors->has('slug'))
                        <span class="text-danger">{{ $errors->first('slug') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.slug_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="controller_of_examination">{{ trans('cruds.convocation.fields.controller_of_examination') }}</label>
                    <input class="form-control {{ $errors->has('controller_of_examination') ? 'is-invalid' : '' }}" type="text" name="controller_of_examination" id="controller_of_examination" value="{{ old('controller_of_examination', '') }}">
                    @if($errors->has('controller_of_examination'))
                        <span class="text-danger">{{ $errors->first('controller_of_examination') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.controller_of_examination_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="controller_of_examination_signature">{{ trans('cruds.convocation.fields.controller_of_examination_signature') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('controller_of_examination_signature') ? 'is-invalid' : '' }}" id="controller_of_examination_signature-dropzone">
                    </div>
                    @if($errors->has('controller_of_examination_signature'))
                        <span class="text-danger">{{ $errors->first('controller_of_examination_signature') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.controller_of_examination_signature_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="vice_chancellor">{{ trans('cruds.convocation.fields.vice_chancellor') }}</label>
                    <input class="form-control {{ $errors->has('vice_chancellor') ? 'is-invalid' : '' }}" type="text" name="vice_chancellor" id="vice_chancellor" value="{{ old('vice_chancellor', '') }}">
                    @if($errors->has('vice_chancellor'))
                        <span class="text-danger">{{ $errors->first('vice_chancellor') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.vice_chancellor_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="vice_chancellor_signature">{{ trans('cruds.convocation.fields.vice_chancellor_signature') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('vice_chancellor_signature') ? 'is-invalid' : '' }}" id="vice_chancellor_signature-dropzone">
                    </div>
                    @if($errors->has('vice_chancellor_signature'))
                        <span class="text-danger">{{ $errors->first('vice_chancellor_signature') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.vice_chancellor_signature_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.convocation.fields.is_active') }}</label>
                    <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active" required>
                        <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Convocation::IS_ACTIVE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active'))
                        <span class="text-danger">{{ $errors->first('is_active') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.is_active_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="certificate_design">{{ trans('cruds.convocation.fields.certificate_design') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('certificate_design') ? 'is-invalid' : '' }}" id="certificate_design-dropzone">
                    </div>
                    @if($errors->has('certificate_design'))
                        <span class="text-danger">{{ $errors->first('certificate_design') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.convocation.fields.certificate_design_helper') }}</span>
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

@section('scripts')
    <script>
        Dropzone.options.controllerOfExaminationSignatureDropzone = {
            url: '{{ route('admin.convocations.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="controller_of_examination_signature"]').remove()
                $('form').append('<input type="hidden" name="controller_of_examination_signature" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="controller_of_examination_signature"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($convocation) && $convocation->controller_of_examination_signature)
                var file = {!! json_encode($convocation->controller_of_examination_signature) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="controller_of_examination_signature" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

    </script>
    <script>
        Dropzone.options.viceChancellorSignatureDropzone = {
            url: '{{ route('admin.convocations.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="vice_chancellor_signature"]').remove()
                $('form').append('<input type="hidden" name="vice_chancellor_signature" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="vice_chancellor_signature"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($convocation) && $convocation->vice_chancellor_signature)
                var file = {!! json_encode($convocation->vice_chancellor_signature) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="vice_chancellor_signature" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

    </script>
    <script>
        Dropzone.options.certificateDesignDropzone = {
            url: '{{ route('admin.convocations.storeMedia') }}',
            maxFilesize: 5, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 5,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="certificate_design"]').remove()
                $('form').append('<input type="hidden" name="certificate_design" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="certificate_design"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($convocation) && $convocation->certificate_design)
                var file = {!! json_encode($convocation->certificate_design) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="certificate_design" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

    </script>
@endsection
