<?php

namespace App\Rules;

use App\Models\Auth\Partner;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Authenticated implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $partner = Partner::where([
            'id' => (int)$value['id'],
            'client_token' => $value['token'],
        ])->first();

        if(!$partner){
            $fail('Invalid token or id provided');
        }
    }
}
