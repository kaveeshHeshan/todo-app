<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoListRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:255',
            'tasks' => 'required|array',
            'tasks.*.title' => 'required|string',
            'tasks.*.due_date' => 'required',
            'tasks.*.due_time' => 'required',
            'tasks.*.status' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tasks.*.title' => 'Title is required',
            'tasks.*.due_date' => 'Due date is required',
            'tasks.*.due_time' => 'Due time is required',
            'tasks.*.status' => 'Status is required',
        ];
    }
}
