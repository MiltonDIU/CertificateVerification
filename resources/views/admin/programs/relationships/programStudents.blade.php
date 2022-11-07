<div class="m-3">
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
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-programStudents">
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
                    <tbody>
                    @foreach($students as $key => $student)
                        <tr data-entry-id="{{ $student->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $student->id ?? '' }}
                            </td>
                            <td>
                                {{ $student->serial_no ?? '' }}
                            </td>
                            <td>
                                {{ $student->name ?? '' }}
                            </td>
                            <td>
                                {{ $student->email ?? '' }}
                            </td>
                            <td>
                                {{ $student->student_id_no ?? '' }}
                            </td>
                            <td>
                                {{ $student->cgpa ?? '' }}
                            </td>
                            <td>
                                {{ $student->out_of_cgpa ?? '' }}
                            </td>
                            <td>
                                {{ $student->certificate_generate_day_month ?? '' }}
                            </td>
                            <td>
                                {{ $student->certificate_generate_year ?? '' }}
                            </td>
                            <td>
                                {{ $student->result_published_date ?? '' }}
                            </td>
                            <td>
                                {{ $student->faculty_name ?? '' }}
                            </td>
                            <td>
                                {{ $student->program_name ?? '' }}
                            </td>
                            <td>
                                {{ $student->convocation_name ?? '' }}
                            </td>
                            <td>
                                {{ $student->hash_code ?? '' }}
                            </td>
                            <td>
                                {{ $student->certificate_url ?? '' }}
                            </td>
                            <td>
                                {{ $student->faculty->name ?? '' }}
                            </td>
                            <td>
                                {{ $student->program->name ?? '' }}
                            </td>
                            <td>
                                {{ $student->convocation->name ?? '' }}
                            </td>
                            <td>
                                @can('student_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.students.show', $student->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('student_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.students.edit', $student->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('student_delete')
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('student_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.students.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
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

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            let table = $('.datatable-programStudents:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
