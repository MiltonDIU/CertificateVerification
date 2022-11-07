@extends('layouts.admin')
@section('content')
    @can('convocation_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.convocations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.convocation.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.convocation.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Convocation">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.convocation.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.convocation.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.convocation.fields.controller_of_examination') }}
                    </th>
                    <th>
                        {{ trans('cruds.convocation.fields.controller_of_examination_signature') }}
                    </th>
                    <th>
                        {{ trans('cruds.convocation.fields.vice_chancellor') }}
                    </th>
                    <th>
                        {{ trans('cruds.convocation.fields.vice_chancellor_signature') }}
                    </th>
                    <th>
                        {{ trans('cruds.convocation.fields.is_active') }}
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
            @can('convocation_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.convocations.massDestroy') }}",
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
                ajax: "{{ route('admin.convocations.index') }}",
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'controller_of_examination', name: 'controller_of_examination' },
                    { data: 'controller_of_examination_signature', name: 'controller_of_examination_signature', sortable: false, searchable: false },
                    { data: 'vice_chancellor', name: 'vice_chancellor' },
                    { data: 'vice_chancellor_signature', name: 'vice_chancellor_signature', sortable: false, searchable: false },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Convocation').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });

    </script>
@endsection
