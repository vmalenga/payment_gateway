<?php

namespace App\Http\Requests\Auth;

use App\Rules\Authenticated;
use App\Rules\CredentialsMatch;
use Illuminate\Foundation\Http\FormRequest;

class AuthVerifyTokenRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $this->merge([
            'credentials' => [
                'id' => $this->id,
                'token' => $this->token,
            ],
        ]);
    }

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
            'id' => [
                'required',
                'exists:partners,id',
            ],
            'token' => [
                'required',
                'exists:partners,client_token',
            ],
            'credentials.id' => ['required'],
            'credentials.token' => ['required'],
            'credentials' => [
                'required',
                'array',
                new Authenticated,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Provide your given authentication id',
            'id.exists' => 'Provided authentication id was not found',

            'token.required' => 'Provide your given authentication token',
            'token.exists' => 'Provided authentication token was not found',
        ];
    }
}
