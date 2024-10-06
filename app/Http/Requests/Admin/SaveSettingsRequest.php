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
            'title' => ['required'],
            'organizer' => ['required'],
            'description' => ['nullable', ],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'confirmation_required' => ['nullable', 'boolean'],
            'confirmation_personalized' => ['nullable', 'boolean'],
            'room_slot_max_pending' => ['nullable', 'integer', 'gte:0'],
            'room_slot_max_claimed' => ['nullable', 'integer', 'gte:0'],
            'room_slot_team_confirmation_required' => ['nullable', 'boolean'],
            'attendees_max' => ['nullable', 'integer', 'gte:0'],
        ];
    }
}
