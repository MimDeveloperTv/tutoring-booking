<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceModelRequest extends FormRequest
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
            'service_category_id' => 'required',
            'name' => 'required|max:65',
            'description' => 'required|max:255',
            'condition' => 'required|max:100',
            'calculation' => 'required|max:100',
            'isActive' => 'required',
            'items' => 'required',
            'are_items_independent' => 'required',
            'non_prescription' => 'required',
            'form_id' => 'required',
        ];
    }
}
