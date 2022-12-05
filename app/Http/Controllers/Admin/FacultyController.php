<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFacultyRequest;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\Faculty;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('faculty_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Faculty::query()->select(sprintf('%s.*', (new Faculty())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'faculty_show';
                $editGate = 'faculty_edit';
                $deleteGate = 'faculty_delete';
                $crudRoutePart = 'faculties';

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
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Faculty::IS_ACTIVE_SELECT[$row->is_active] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.faculties.index');
    }

    public function create()
    {
        abort_if(Gate::denies('faculty_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.faculties.create');
    }

    public function store(StoreFacultyRequest $request)
    {
        $faculty = Faculty::create($request->all());

        return redirect()->route('admin.faculties.index');
    }

    public function edit(Faculty $faculty)
    {
        abort_if(Gate::denies('faculty_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->all());

        return redirect()->route('admin.faculties.index');
    }

    public function show(Faculty $faculty)
    {
        abort_if(Gate::denies('faculty_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculty->load('facultyPrograms', 'facultyStudents');

        return view('admin.faculties.show', compact('faculty'));
    }

    public function destroy(Faculty $faculty)
    {
        abort_if(Gate::denies('faculty_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculty->delete();

        return back();
    }

    public function massDestroy(MassDestroyFacultyRequest $request)
    {
        Faculty::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
