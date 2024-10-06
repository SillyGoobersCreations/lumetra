<?php


namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SetupRoomSlotsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: Permission Check
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
            'date' => ['required', 'string'],
            'start_hour' => ['required', 'integer', 'min:0', 'max:23'],
            'start_minute' => ['required', 'integer', 'min:0', 'max:59'],
            'end_hour' => ['required', 'integer', 'min:0', 'max:23'],
            'end_minute' => ['required', 'integer', 'min:0', 'max:59'],
            'duration' => ['required', 'integer'],
            'time_between_slots' => ['required', 'integer'],
        ];
    }
}
