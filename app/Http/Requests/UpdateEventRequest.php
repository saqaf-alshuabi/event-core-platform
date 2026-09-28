<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'filled|string|max:255',
            'description' => 'filled|string',
            'end_date' => 'filled|date',
            'start_date' => 'filled|date',
            'location' => 'filled|string|max:255',
            'image' => 'filled|image|mimes:jpeg,png,jpg,gif,svg|max:3072',

        ];
    }
}
