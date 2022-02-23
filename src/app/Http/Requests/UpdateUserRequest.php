<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstName' => ['string', 'min:1', 'max:255'],
            'lastName'  => ['string', 'min:1', 'max:255'],
            'email'     => ['string', 'email:rfc', 'min:1', 'max:255', 'unique:App\Models\User,email'],
            'phone'     => ['string', 'min:1', 'max:255', 'unique:App\Models\User,phone'],
        ];
    }
}
