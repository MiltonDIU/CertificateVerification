<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true; //Gate::allows('student_create');
    }

    public function rules()
    {
        return [
            'serial_no' => [
                'string',
                'required',
                'unique:students',
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
                'unique:students',
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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }

}
