<?php

namespace App\Http\Requests;

use App\Services\ProfileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $profile = $this->user()->profile;

        return [
            'username' => [
                'sometimes',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-z0-9_]+$/',
                Rule::unique('profiles')->ignore($profile?->id),
                Rule::notIn(ProfileService::getReservedUsernames()),
            ],
            'display_name' => 'sometimes|string|max:100',
            'bio' => 'nullable|string|max:500',
            'background_type' => 'sometimes|in:solid,gradient,image',
            'background_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'gradient_start' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'gradient_end' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'gradient_direction' => 'nullable|string|in:to-r,to-l,to-t,to-b,to-tr,to-tl,to-br,to-bl',
            'theme' => 'sometimes|string|max:30',
            'font_family' => 'sometimes|string|max:50',
            'button_style' => 'sometimes|in:rounded,pill,square,soft',
            'button_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_text_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'seo_title' => 'nullable|string|max:100',
            'seo_description' => 'nullable|string|max:300',
            'is_published' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'Username can only contain lowercase letters, numbers, and underscores.',
            'username.not_in' => 'This username is reserved.',
            'background_color.regex' => 'Please enter a valid hex color code.',
        ];
    }
}
