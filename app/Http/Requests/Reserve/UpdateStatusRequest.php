<?php

namespace App\Http\Requests\Reserve;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|in:NEW,CANCELED,COMPLETED,REVIEWED',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
