<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username'  => ['required', 'string', 'min:1', 'max:255', 'unique:App\Models\User,username'],
            'firstName' => ['required', 'string', 'min:1', 'max:255'],
            'lastName'  => ['required', 'string', 'min:1', 'max:255'],
            'email'     => ['required', 'string', 'email:rfc', 'min:1', 'max:255', 'unique:App\Models\User,email'],
            'phone'     => ['required', 'string', 'min:1', 'max:255', 'unique:App\Models\User,phone'],
        ];
    }
}
