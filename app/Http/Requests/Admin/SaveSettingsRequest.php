<?php


namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveSettingsRequest extends FormRequest
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
            'state' => ['required', 'in:draft,public,hidden'],
            'title' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'description' => ['nullable'],
            'start_date' => ['nullable', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'email_name' => ['nullable', 'string', 'max:255'],
            'email_from' => ['nullable', 'string', 'max:255'],
            'confirmation_required' => ['nullable', 'boolean'],
            'confirmation_personalized' => ['nullable', 'boolean'],
            'confirmation_key' => ['nullable', 'string'],
            'room_slot_max_pending' => ['nullable', 'integer', 'gte:0'],
            'room_slot_max_claimed' => ['nullable', 'integer', 'gte:0'],
            'room_slot_team_confirmation_required' => ['nullable', 'boolean'],
            'enrollment_enabled' => ['required', 'boolean'],
            'privacy_url' => ['required', 'url', 'max:255'],
            'attendees_max' => ['nullable', 'integer', 'gte:0'],
        ];
    }
}
