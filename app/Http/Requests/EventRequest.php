<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::id() > 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.request_id' => 'required|uuid',
            '*.category' => 'required|string|min:1|max:255',
            '*.name' => 'required|string|min:1|max:255',
            '*.label' => 'required|string|min:1|max:255',
            '*.payload' => 'array',
            '*.request_url' => 'required|url',
            '*.identify' => 'required|uuid',
            '*.client_id' => 'string',
            '*.datetime' => 'required|date',
        ];
    }

}
