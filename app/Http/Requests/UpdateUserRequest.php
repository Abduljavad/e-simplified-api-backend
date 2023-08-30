<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('accessResource', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $userId = $this->route('user');
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::unique('users')->ignore($userId),
            ],
            'phone_number' => [
                'required',
                Rule::unique('users')->ignore($userId),
            ],
            'avatar' => 'file|nullable',
        ];
    }
}
