<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Convocation;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use PDF;
class StudentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Student::with(['faculty', 'program', 'convocation'])->select(sprintf('%s.*', (new Student())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'student_show';
                $editGate = 'student_edit';
                $deleteGate = 'student_delete';
                $crudRoutePart = 'students';

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
            $table->editColumn('serial_no', function ($row) {
                return $row->serial_no ? $row->serial_no : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('student_id_no', function ($row) {
                return $row->student_id_no ? $row->student_id_no : '';
            });
            $table->editColumn('cgpa', function ($row) {
                return $row->cgpa ? $row->cgpa : '';
            });
            $table->editColumn('out_of_cgpa', function ($row) {
                return $row->out_of_cgpa ? $row->out_of_cgpa : '';
            });
            $table->editColumn('certificate_generate_day_month', function ($row) {
                return $row->certificate_generate_day_month ? $row->certificate_generate_day_month : '';
            });
            $table->editColumn('certificate_generate_year', function ($row) {
                return $row->certificate_generate_year ? $row->certificate_generate_year : '';
            });
            $table->editColumn('result_published_date', function ($row) {
                return $row->result_published_date ? $row->result_published_date : '';
            });
            $table->editColumn('faculty_name', function ($row) {
                return $row->faculty_name ? $row->faculty_name : '';
            });
            $table->editColumn('program_name', function ($row) {
                return $row->program_name ? $row->program_name : '';
            });
            $table->editColumn('convocation_name', function ($row) {
                return $row->convocation_name ? $row->convocation_name : '';
            });
            $table->editColumn('hash_code', function ($row) {
                return $row->hash_code ? $row->hash_code : '';
            });
            $table->editColumn('certificate_url', function ($row) {
                return $row->certificate_url ? $row->certificate_url : '';
            });
            $table->addColumn('faculty_name', function ($row) {
                return $row->faculty ? $row->faculty->name : '';
            });

            $table->addColumn('program_name', function ($row) {
                return $row->program ? $row->program->name : '';
            });

            $table->addColumn('convocation_name', function ($row) {
                return $row->convocation ? $row->convocation->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'faculty', 'program', 'convocation']);

            return $table->make(true);
        }

        return view('admin.students.index');
    }

    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $programs = Program::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $convocations = Convocation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.students.create', compact('convocations', 'faculties', 'programs'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());

        return redirect()->route('admin.students.index');
    }

    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $programs = Program::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $convocations = Convocation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $student->load('faculty', 'program', 'convocation');

        return view('admin.students.edit', compact('convocations', 'faculties', 'programs', 'student'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return redirect()->route('admin.students.index');
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('faculty', 'program', 'convocation');

        return view('admin.students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentRequest $request)
    {
        Student::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
    public function certificate(){
        Pdf::loadView('admin.students.certificate')->setPaper('a4', 'landscape')->save(public_path().'/certificate/my_stored_file.pdf')->stream('download.pdf');
    }

}
