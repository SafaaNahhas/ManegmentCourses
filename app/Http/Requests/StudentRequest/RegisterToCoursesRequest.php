<?php

namespace App\Http\Requests\StudentRequest;

use Illuminate\Foundation\Http\FormRequest;

class RegisterToCoursesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id', // Validate each course ID
        ];
    }
    public function messages()
    {
        return [
            'courses.required' => 'You must provide at least one course.',
            'courses.*.exists' => 'The selected course does not exist.',
        ];
    }
}
