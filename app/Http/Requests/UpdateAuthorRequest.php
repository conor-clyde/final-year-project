<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAuthorRequest extends FormRequest
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
        $authorId = $this->route('author')->id;

        return [
            'surname' => 'required|max:255',
            'forename' => [
                'required',
                'max:255',
                Rule::unique('authors')->where(function ($query) {
                    return $query->where('surname', $this->input('surname'));
                })->ignore($authorId),
            ],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'forename.unique' => 'An author with the given surname and forename already exists.',
        ];
    }
} 