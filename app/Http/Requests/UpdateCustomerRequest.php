<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /* Es para permitir las peticiones para enviar 
        informacion */
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
            'born_date' => array(
                'required', 'date'
            ),
            'dui' => array(
                'required', 
                'regex:/^[0-9]{8}-[0-9]{1}/m', // 12345678-9
            ),
            'address' => array(
                'required'
            )
        ];
    }
}
