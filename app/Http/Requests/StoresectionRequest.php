<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoresectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'icon' => 'nullable',
            'ordering_number' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
        ];
    }
}
