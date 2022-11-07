<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Http\Resources\Admin\ProgramResource;
use App\Models\Program;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgramsApiController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('program_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProgramResource(Program::with(['faculty'])->get());
    }

    public function store(StoreProgramRequest $request)
    {
        $program = Program::create($request->all());

        return (new ProgramResource($program))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Program $program)
    {
        //abort_if(Gate::denies('program_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProgramResource($program->load(['faculty']));
    }

    public function update(UpdateProgramRequest $request, Program $program)
    {
        $program->update($request->all());

        return (new ProgramResource($program))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Program $program)
    {
        //abort_if(Gate::denies('program_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $program->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
