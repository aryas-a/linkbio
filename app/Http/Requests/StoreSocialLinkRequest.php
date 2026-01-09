<?php

namespace App\Http\Requests;

use App\Models\SocialLink;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSocialLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $profile = $this->user()->profile;

        return [
            'platform' => [
                'required',
                'string',
                Rule::in(array_keys(SocialLink::PLATFORMS)),
                Rule::unique('social_links')->where(function ($query) use ($profile) {
                    return $query->where('profile_id', $profile?->id);
                }),
            ],
            'url' => 'required|url|max:2048',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'platform.in' => 'Please select a valid platform.',
            'platform.unique' => 'You already have a link for this platform.',
        ];
    }
}
