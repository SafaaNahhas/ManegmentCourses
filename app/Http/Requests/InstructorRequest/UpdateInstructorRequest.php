<?php

namespace App\Http\Requests\InstructorRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstructorRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:instructors',
            'experience' => 'sometimes|string|max:255',
            'specialty' => 'sometimes|string|max:255',
            'courses' => 'array',
            'courses.*' => 'exists:courses,id'
        ];
    }
    public function messages()
    {
        return [
            
            'courses.*.exists' => 'One or more selected courses do not exist.',
        ];
    }
}
