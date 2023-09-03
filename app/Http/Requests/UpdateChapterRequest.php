<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChapterRequest extends FormRequest
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
            'section_id' => 'required|exists:sections,id',
            'icon' => 'nullable',
            'ordering_number' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
        ];
    }
}
