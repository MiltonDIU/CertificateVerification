<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreConvocationRequest;
use App\Http\Requests\UpdateConvocationRequest;
use App\Http\Resources\Admin\ConvocationResource;
use App\Models\Convocation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvocationsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //abort_if(Gate::denies('convocation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ConvocationResource(Convocation::all());
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

        return (new ConvocationResource($convocation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Convocation $convocation)
    {
        //abort_if(Gate::denies('convocation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ConvocationResource($convocation);
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

        return (new ConvocationResource($convocation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Convocation $convocation)
    {
        //abort_if(Gate::denies('convocation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $convocation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
