<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:100',
            'url' => 'sometimes|url|max:2048',
            'icon' => 'nullable|string|max:50',
            'position' => 'sometimes|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'open_new_tab' => 'sometimes|boolean',
            'scheduled_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:scheduled_at',
        ];
    }
}
