<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'arn' => ['required'],
            'vpc' => ['required'],
            'protocol' => ['required'],
            'port' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
