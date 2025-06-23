<?php

namespace Tests\Feature;

use App\Rules\RegistrationRule;
use App\Rules\Upppercase;
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
            "name" => [
                "first" => "Eko",
                "last" => "Kurniawan"
            ],
            "address" => [
                "street" => "Jl. Mangga",
                "city" => "Jakarta",
                "country" => "Indonesia"
            ]
        ];
        $rules = [
            "name.first" => ["required", "max:100"],
            "name.last" => ["max:100"],
            "address.street" => ["max:200"],
            "address.city" => ["required", "max:100"],
            "address.country" => ["required", "max:100"]
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }

    public function testIndexedArrayValidation()
    {

        $data = [
            "name" => [
                "first" => "Eko",
                "last" => "Kurniawan"
            ],
            "address" => [
                [
                    "street" => "Jl. Mangga",
                    "city" => "Jakarta",
                    "country" => "Indonesia"
                ],
                [
                    "street" => "Jl. Manggis",
                    "city" => "Jakarta",
                    "country" => "Indonesia"
                ]
            ]
        ];
        $rules = [
            "name.first" => ["required", "max:100"],
            "name.last" => ["max:100"],
            "address.*.street" => ["max:200"],
            "address.*.city" => ["required", "max:100"],
            "address.*.country" => ["required", "max:100"]
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }
}
