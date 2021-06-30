<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Auth\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected string $redirectTo = '/';

    /**
     * {@inheritdoc}
     */
    protected function authenticated(Request $request, User $user): JsonResponse
    {
        return response()->json(
            ['message' => 'ok'],
            Response::HTTP_OK
        );
    }

    public function user(): UserResource
    {
        return UserResource::make(
            Auth::forceUser()->load(UserResource::RELATIONS)
        );
    }
}
