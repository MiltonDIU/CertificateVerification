<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_edit');
    }

    public function rules()
    {
        return [
            'serial_no' => [
                'string',
                'required',
                'unique:students,serial_no,' . request()->route('student')->id,
            ],
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'string',
                'nullable',
            ],
            'student_id_no' => [
                'string',
                'required',
                'unique:students,student_id_no,' . request()->route('student')->id,
            ],
            'cgpa' => [
                'string',
                'required',
            ],
            'out_of_cgpa' => [
                'string',
                'required',
            ],
            'certificate_generate_day_month' => [
                'string',
                'required',
            ],
            'certificate_generate_year' => [
                'string',
                'required',
            ],
            'result_published_date' => [
                'string',
                'required',
            ],
            'faculty_name' => [
                'string',
                'required',
            ],
            'program_name' => [
                'string',
                'required',
            ],
            'convocation_name' => [
                'string',
                'required',
            ],
        ];
    }
}
