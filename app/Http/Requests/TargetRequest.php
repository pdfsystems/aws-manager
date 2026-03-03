<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'target_group_id' => ['required', 'exists:target_groups,id'],
            'instance' => ['required'],
            'state' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
