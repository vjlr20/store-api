<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveInfoRequest extends FormRequest
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
            'names' => array(
                'required'
            ),
            'lastnames' => array(
                'required'
            ),
            'bornDate' => array(
                'required', 'date'
            ),
            'dui' => array(
                'required'
            ),
            'age' => array(
                'required', 'integer'
            )
        ];
    }
}
