<?php

namespace App\Http\Requests;

use App\Models\Convocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateConvocationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('convocation_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'nullable',
            ],
            'controller_of_examination' => [
                'string',
                'nullable',
            ],
            'vice_chancellor' => [
                'string',
                'nullable',
            ],
            'is_active' => [
                'required',
            ],
        ];
    }
}
