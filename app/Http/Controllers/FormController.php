<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

class FormController extends Controller
{

    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                "username" => "required",
                "password" => "required"
            ]);
            return response("Ok", Response::HTTP_OK);
        } catch (ValidationException $exception) {
            return response($exception->errors(), Response::HTTP_BAD_REQUEST);
        }
    }
}
