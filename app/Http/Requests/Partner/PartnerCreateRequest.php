<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerCreateRequest extends FormRequest
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
        if($this->country_id === null){
            return [
                'country_id' => [
                    'required',
                    'exists:countries,id'
                ],
            ];
        }

        $country_id = $this->country_id;

        return [
            'country_id' => [
                'required',
                'exists:countries,id'
            ],
            'name' => [
                'required',
                Rule::unique('partners')->where(function($q) use($country_id){
                    $q->where([
                        'country_id' => $country_id,
                        'deleted_at' => null,
                    ]);
                }),
            ],
            'client_id' => [
                'required',
                'exists:oauth_clients,id',
                Rule::unique('partners'),
            ],
            'client_token' => [
                'required',
                'exists:oauth_clients,secret',
                Rule::unique('partners'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'Specified country of the partner',
            'country_id.exists' => 'The specified country was not found',

            'name.required' => 'Provide partner name',
            'name.unique' => 'The partner already exists',

            'client_id.required' => 'Provide the given partner ID',
            'client_id.exists' => 'Partner ID was not found',
            'client_id.unique' => 'Partner ID provided has been used',

            'client_token.required' => 'Provide the given partner token',
            'client_token.exists' => 'Partner token was not found',
            'client_token.unique' => 'Partner token provided has been used',
        ];
    }
}
