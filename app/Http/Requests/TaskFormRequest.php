<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'desc'        => 'nullable|string|max:1000',
            'priority'    => 'required|string|in:low,medium,high',
            'due_date'    => 'date|after_or_equal:today|date_format:d-m-Y H:i',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title'       => 'عنوان',
            'desc'        => 'الوصف',
            'priority'    => 'الأولوية',
            'due_date'    => 'تاريخ الاستحقاق',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required'       => 'حقل العنوان مطلوب.',
            'title.string'         => 'يجب أن يكون العنوان نصاً.',
            'title.max'            => 'يجب أن لا يتجاوز العنوان 255 حرفاً.',

            'desc.string'          => 'يجب أن يكون الوصف نصاً.',
            'desc.max'             => 'يجب أن لا يتجاوز الوصف 1000 حرف.',

            'priority.required'    => 'حقل الأولوية مطلوب.',
            'priority.string'      => 'يجب أن تكون الأولوية نصاً.',
            'priority.in'          => 'القيمة المختارة للأولوية غير صالحة.',

            'due_date.date'        => 'يجب أن يكون تاريخ الاستحقاق تاريخاً صالحاً.',
            'due_date.after_or_equal' => 'تاريخ الاستحقاق يجب أن يكون بعد أو يساوي تاريخ اليوم.',

        ];
    }
}
