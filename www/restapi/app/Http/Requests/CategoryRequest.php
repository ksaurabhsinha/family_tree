<?php

namespace App\Http\Requests;


use Illuminate\Http\Request;

class CategoryRequest extends Request
{
    public function authorize(): bool
    {
        return TRUE;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required',
            'parent_id' => 'integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Please provide Category Name',
            'parent_id.integer' => 'Parent Id must be an integer value',
        ];
    }
}