<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class RegistrationRule implements ValidationRule, DataAwareRule, ValidatorAwareRule
{

    private array $data;
    private Validator $validator;


    public function setData(array $data)
    {
        $this->data = $data;
        return $this->data;
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
        return $this->validator;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if ($this->data["username"] !== $value) {
            $fail("validation.custom.registrationRule")->translate(
                [
                    "attribute" => $attribute,
                    "value" => $value
                ],
                "id"
            );
        }
    }
}
