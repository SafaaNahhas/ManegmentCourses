<?php

namespace App\Http\Requests\CourseReqest;

use Illuminate\Foundation\Http\FormRequest;

class AttachStudentRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',

        ];
    }
    public function messages()
    {
        return [
            'student_id.exists' =>'هذا العنصر غير موجود',

        ];
    }
}
