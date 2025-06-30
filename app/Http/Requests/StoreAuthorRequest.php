<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // For now, we'll allow anyone to create an author.
        // We can add authorization logic here later if needed.
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
            'surname' => 'required|max:255',
            'forename' => [
                'required',
                'max:255',
                Rule::unique('authors')->where(function ($query) {
                    return $query->where('surname', $this->input('surname'));
                }),
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
            'surname.required' => 'Please provide the author\'s surname.',
            'forename.required' => 'Please provide the author\'s forename.',
            'surname.max' => 'The author\'s surname must not exceed 255 characters.',
            'forename.max' => 'The author\'s forename must not exceed 255 characters.',
        ];
    }
} 