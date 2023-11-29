<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTGuard;

class BaseController extends Controller
{
    public User $user;

    protected function getUser(Request $request): ?User
    {
        $this->user = $request->user();

        return $this->user;
    }

    protected function guard(): JWTGuard
    {
        /**@var $guard JWTGuard*/
        $guard = Auth::guard();

        return $guard;
    }

    protected function invalidAuthRes(): JsonResponse
    {
        return resJson([
            'code'  => 200, //400,
            'error' => [
                'user' => trans('v1/auth.error_username_not_exist')
            ]
        ]);
    }

    protected function unexpectedErrorRes(): JsonResponse
    {
        return resJson([
            'code'  => 200, //500,
            'error' => [
                'unexpected' => trans('v1/default.error_unexpected_error')
            ]
        ]);
    }
}
