<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'url' => 'required|url|max:2048',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'sometimes|boolean',
            'open_new_tab' => 'sometimes|boolean',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:scheduled_at',
        ];
    }

    public function messages(): array
    {
        return [
            'url.url' => 'Please enter a valid URL.',
            'scheduled_at.after' => 'Schedule time must be in the future.',
            'expires_at.after' => 'Expiry time must be after the scheduled time.',
        ];
    }
}
