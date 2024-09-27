<?php

namespace App\Http\Requests\CourseReqest;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'instructors' => 'sometimes|array',
            'instructors.*' => 'exists:instructors,id',      ];
    }
    public function messages()
    {
        return [
            'title.unique' => 'عنوان الدورة مُستخدم بالفعل. يرجى اختيار عنوان آخر.',
            'instructors.*.exists' => 'One or more selected instructors do not exist.',

        ];
    }
}
