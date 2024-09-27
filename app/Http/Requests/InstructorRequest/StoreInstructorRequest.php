<?php

namespace App\Http\Requests\InstructorRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstructorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors',
            'experience' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'courses' => 'array',
            'courses.*' => 'exists:courses,id'
        ];
    }
    public function messages()
    {
        return [
            'courses.required' => 'Please provide at least one course.',
            'courses.array' => 'Courses must be an array of course IDs.',
            'courses.*.integer' => 'Each course ID must be an integer.',
            'courses.*.exists' => 'One or more selected courses do not exist.',
        ];
    }
}
