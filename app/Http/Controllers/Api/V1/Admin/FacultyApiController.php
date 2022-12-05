<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Http\Resources\Admin\FacultyResource;
use App\Models\Faculty;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacultyApiController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('faculty_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FacultyResource(Faculty::all());
    }

    public function store(StoreFacultyRequest $request)
    {
        $faculty = Faculty::create($request->all());

        return (new FacultyResource($faculty))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Faculty $faculty)
    {
        //abort_if(Gate::denies('faculty_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return new FacultyResource($faculty);
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->all());

        return (new FacultyResource($faculty))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Faculty $faculty)
    {
        //abort_if(Gate::denies('faculty_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculty->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
