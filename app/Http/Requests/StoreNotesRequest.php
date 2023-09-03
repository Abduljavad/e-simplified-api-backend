<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotesRequest extends FormRequest
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
            'chapter_id' => 'exists:chapters,id|required',
            'name' => 'required|string',
            'description' => 'required|string',
            'url' => 'required',
            'type' => 'nullable|string',
            'is_free' => 'boolean',
        ];
    }
}
