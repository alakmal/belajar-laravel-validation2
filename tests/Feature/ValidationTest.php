<?php

namespace Tests\Feature;

use App\Rules\RegistrationRule;
use App\Rules\Upppercase;
use Closure;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;

class ValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testValidation()
    {

        $data = [
            "username" => "admin",
            "password" => "12345"
        ];

        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }

    public function testError()
    {
        App::setLocale("id");
        $data = [
            "username" => "example@gmail.com",
            "password" => "rahasia"
        ];

        $rules = [
            "username" => ["required", "email", "max:100", function (string $attibute, string $value, Closure $fail) {
                if (strtoupper($value) != $value) {
                    $fail("validation.custom.uppercase")->translate([
                        "attribute" => $attibute,
                        "value" => $value
                    ]);
                }
            }],
            "password" => ["required", "min:6", "max:20", new RegistrationRule()]
        ];

        $validator = Validator::make($data, $rules);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());
        dump($validator->errors()->toJson(JSON_PRETTY_PRINT));
    }
}
