<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $data = [
            "username" => "admin",
            "password" => "rahasia"
        ];

        $rules = [
            "username" => "required|email|max:100",
            "password" => ["required", "min:6", "max:20"]
        ];

        $validator = Validator::make($data, $rules);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());
        // dd($validator->errors()->toJson());
        Log::info($validator->errors()->toJson(JSON_PRETTY_PRINT));
    }
}
