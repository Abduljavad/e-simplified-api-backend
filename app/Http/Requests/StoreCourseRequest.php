<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'name' => 'required',
            'sub_title' => 'nullable',
            'description' => 'nullable',
            'is_free' => 'boolean|required',
            'thumbnail' => 'array',
            'banner_image' => 'array',
            'category_id' => 'required|exists:categories,id',
            'course_offerings' => 'array',
            'course_outcomes' => 'array',
            'teachers' => 'array|required',
        ];
    }
}
