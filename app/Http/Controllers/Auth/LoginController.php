<?php

namespace App\Http\Controllers\Auth;

use App\Data\User\UserData;
use App\Facades\Auth;
use App\Http\Controllers\Controller;
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

    public function user(): UserData
    {
        return UserData::fromModel(
            Auth::forceUser()->load('permissions')
        );
    }
}
