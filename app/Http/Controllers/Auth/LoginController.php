<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function user(): UserResource
    {
        return UserResource::make(
            Auth::forceUser()->load(UserResource::RELATIONS)
        );
    }
}
