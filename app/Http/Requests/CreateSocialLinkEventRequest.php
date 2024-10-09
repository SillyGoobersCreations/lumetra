<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSocialLinkEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required','string', 'in:web,twitter,bluesky,facebook,linkedin,discord,mastodon,github,youtube,reddit'],
            'value' => ['nullable','string', 'max:255'],
            'visibility' => ['required', 'string', 'in:public,connections_only,hidden'],
        ];
    }
}
