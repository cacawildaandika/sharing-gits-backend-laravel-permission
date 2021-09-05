<?php

namespace App\Http\Controllers;

use App\Helpers\BasicResponse;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $basicResponse;

    public function __construct()
    {
        $this->basicResponse = new BasicResponse();
    }

    public function user(): JsonResponse
    {
        $user = Auth::user();
        return $this->basicResponse
            ->setStatusCode(200)
            ->setMessage('Success get user')
            ->setData([
                'roles' => $user->getRoleNames(),
                'permission_direct' => $user->getDirectPermissions(),
                'permission_role' => $user->getPermissionsViaRoles(),
                'permissions' => $user->getAllPermissions(),
                'user' => $user,
            ])
            ->send();
    }

    public function login(Request $request): JsonResponse
    {
        $user = User::find(3);
        $token = $user->createToken($user->id)->accessToken;
        return $this->basicResponse
                ->setStatusCode(200)
                ->setMessage('Login success')
                ->setData([
                    'user' => $user,
                    'token' => $token
                ])->send();

//        $credentials = $request->only(['email', 'password']);

//        if (Auth::check($credentials)) {
//            $user = Auth::user();
//            $token = $user->createToken($user->id)->accessToken;
//
//            return $this->basicResponse
//                ->setStatusCode(200)
//                ->setMessage('Login success')
//                ->setData([
//                    'user' => $user,
//                    'token' => $token
//                ])->send();
//        }
//
//        return $this->basicResponse
//            ->setStatusCode(401)
//            ->setMessage('Email or password not match')
//            ->send();
    }
}
