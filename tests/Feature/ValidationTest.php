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

    public function testLoginSuccess()
    {
        $response = $this->post("/form/login", [
            "username" => "admin",
            "password" => "rahasia"
        ]);

        $response->assertStatus(200);
    }

    public function testLoginFailed()
    {
        $response = $this->post("/form/login", [
            "username" => "",
            "password" => ""
        ]);

        $response->assertStatus(400);
    }
}
