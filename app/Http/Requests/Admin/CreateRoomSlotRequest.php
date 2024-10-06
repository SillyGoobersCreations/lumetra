<?php


namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoomSlotRequest extends FormRequest
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
            'start_hour' => ['required', 'integer', 'min:0', 'max:23'],
            'start_minute' => ['required', 'integer', 'min:0', 'max:59'],
            'end_hour' => ['required', 'integer', 'min:0', 'max:23'],
            'end_minute' => ['required', 'integer', 'min:0', 'max:59'],
            'notes' => ['nullable', 'string'],
            'state' => ['required', 'in:open,reserved,unavailable'],
        ];
    }
}
