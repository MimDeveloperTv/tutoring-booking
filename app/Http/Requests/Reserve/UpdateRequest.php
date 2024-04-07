<?php

namespace App\Http\Requests\Reserve;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_status' => 'required|in:SUCCESS,FAILED,PENDING'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
