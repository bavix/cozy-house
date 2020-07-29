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
        return Auth::check();
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
            '*.referrer_url' => 'url',
            '*.identify' => 'required|uuid',
            '*.client_id' => 'string',
            '*.datetime' => 'required|date',

            // analytics
            '*._ga' => 'string',
            '*._gid' => 'string',
            '*._ga_cid' => 'string',
            '*.__gads' => 'string',
            '*._ym_uid' => 'string',
            '*._ym_d' => 'string',
            '*.tmr_lvid' => 'string',
            '*.tmr_lvidts' => 'string',
            '*._fbp' => 'string',
        ];
    }

}
