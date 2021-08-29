<?php

namespace App\Http\Controllers;

use App\Helpers\BasicResponse;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $basicResponse;

    public function __construct()
    {
        $this->basicResponse = new BasicResponse();
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken($user->id)->accessToken;

            return $this->basicResponse
                ->setStatusCode(200)
                ->setMessage('Login success')
                ->setData([
                    'user' => $user,
                    'token' => $token
                ])->send();
        }

        return 'false';
    }
}