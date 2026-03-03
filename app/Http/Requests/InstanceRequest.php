<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'architecture' => ['required'],
            'state' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
