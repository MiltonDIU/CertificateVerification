@extends('layouts.admin')
@section('content')
    @can('student_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.students.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.student.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.student.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Student">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.student.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.serial_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.student_id_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.cgpa') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.out_of_cgpa') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.certificate_generate_day_month') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.certificate_generate_year') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.result_published_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.faculty_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.program_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.convocation_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.hash_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.certificate_url') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.faculty') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.program') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.convocation') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('student_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.students.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.students.index') }}",
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'id', name: 'id' },
                    { data: 'serial_no', name: 'serial_no' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'student_id_no', name: 'student_id_no' },
                    { data: 'cgpa', name: 'cgpa' },
                    { data: 'out_of_cgpa', name: 'out_of_cgpa' },
                    { data: 'certificate_generate_day_month', name: 'certificate_generate_day_month' },
                    { data: 'certificate_generate_year', name: 'certificate_generate_year' },
                    { data: 'result_published_date', name: 'result_published_date' },
                    { data: 'faculty_name', name: 'faculty_name' },
                    { data: 'program_name', name: 'program_name' },
                    { data: 'convocation_name', name: 'convocation_name' },
                    { data: 'hash_code', name: 'hash_code' },
                    { data: 'certificate_url', name: 'certificate_url' },
                    { data: 'faculty_name', name: 'faculty.name' },
                    { data: 'program_name', name: 'program.name' },
                    { data: 'convocation_name', name: 'convocation.name' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Student').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });

    </script>
@endsection
