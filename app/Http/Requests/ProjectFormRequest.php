<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        return $user->is_admin == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_name' => 'required|string|max:255',
            'project_desc' => 'nullable|string',
        ];
    }
    /**
     * Get custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'project_name' => 'اسم المشروع',
            'project_desc' => 'وصف المشروع',
        ];
    }

    /**
     * Customize the error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'project_name.required' => 'الرجاء إدخال اسم المشروع.',
            'project_name.string'   => 'اسم المشروع يجب أن يكون نصاً.',
            'project_name.max'      => 'اسم المشروع قد لا يتجاوز 255 حرفاً.',
            'project_desc.string'   => 'وصف المشروع يجب أن يكون نصاً.',
        ];
    }
}
