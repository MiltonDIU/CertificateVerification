<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyConvocationRequest;
use App\Http\Requests\StoreConvocationRequest;
use App\Http\Requests\UpdateConvocationRequest;
use App\Models\Convocation;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ConvocationsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('convocation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Convocation::query()->select(sprintf('%s.*', (new Convocation())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'convocation_show';
                $editGate = 'convocation_edit';
                $deleteGate = 'convocation_delete';
                $crudRoutePart = 'convocations';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('controller_of_examination', function ($row) {
                return $row->controller_of_examination ? $row->controller_of_examination : '';
            });
            $table->editColumn('controller_of_examination_signature', function ($row) {
                if ($photo = $row->controller_of_examination_signature) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('vice_chancellor', function ($row) {
                return $row->vice_chancellor ? $row->vice_chancellor : '';
            });
            $table->editColumn('vice_chancellor_signature', function ($row) {
                if ($photo = $row->vice_chancellor_signature) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Convocation::IS_ACTIVE_SELECT[$row->is_active] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'controller_of_examination_signature', 'vice_chancellor_signature']);

            return $table->make(true);
        }

        return view('admin.convocations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('convocation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.convocations.create');
    }

    public function store(StoreConvocationRequest $request)
    {
        $convocation = Convocation::create($request->all());

        if ($request->input('controller_of_examination_signature', false)) {
            $convocation->addMedia(storage_path('tmp/uploads/' . basename($request->input('controller_of_examination_signature'))))->toMediaCollection('controller_of_examination_signature');
        }

        if ($request->input('vice_chancellor_signature', false)) {
            $convocation->addMedia(storage_path('tmp/uploads/' . basename($request->input('vice_chancellor_signature'))))->toMediaCollection('vice_chancellor_signature');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $convocation->id]);
        }

        return redirect()->route('admin.convocations.index');
    }

    public function edit(Convocation $convocation)
    {
        abort_if(Gate::denies('convocation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.convocations.edit', compact('convocation'));
    }

    public function update(UpdateConvocationRequest $request, Convocation $convocation)
    {
        $convocation->update($request->all());

        if ($request->input('controller_of_examination_signature', false)) {
            if (!$convocation->controller_of_examination_signature || $request->input('controller_of_examination_signature') !== $convocation->controller_of_examination_signature->file_name) {
                if ($convocation->controller_of_examination_signature) {
                    $convocation->controller_of_examination_signature->delete();
                }
                $convocation->addMedia(storage_path('tmp/uploads/' . basename($request->input('controller_of_examination_signature'))))->toMediaCollection('controller_of_examination_signature');
            }
        } elseif ($convocation->controller_of_examination_signature) {
            $convocation->controller_of_examination_signature->delete();
        }

        if ($request->input('vice_chancellor_signature', false)) {
            if (!$convocation->vice_chancellor_signature || $request->input('vice_chancellor_signature') !== $convocation->vice_chancellor_signature->file_name) {
                if ($convocation->vice_chancellor_signature) {
                    $convocation->vice_chancellor_signature->delete();
                }
                $convocation->addMedia(storage_path('tmp/uploads/' . basename($request->input('vice_chancellor_signature'))))->toMediaCollection('vice_chancellor_signature');
            }
        } elseif ($convocation->vice_chancellor_signature) {
            $convocation->vice_chancellor_signature->delete();
        }

        return redirect()->route('admin.convocations.index');
    }

    public function show(Convocation $convocation)
    {
        abort_if(Gate::denies('convocation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $convocation->load('convocationStudents');

        return view('admin.convocations.show', compact('convocation'));
    }

    public function destroy(Convocation $convocation)
    {
        abort_if(Gate::denies('convocation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $convocation->delete();

        return back();
    }

    public function massDestroy(MassDestroyConvocationRequest $request)
    {
        Convocation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('convocation_create') && Gate::denies('convocation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Convocation();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
