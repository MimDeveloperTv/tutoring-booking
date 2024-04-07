<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'description' => ['required'],
            'phone' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
