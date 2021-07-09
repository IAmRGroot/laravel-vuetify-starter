<?php

namespace App\Facades;

use App\Models\Auth\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Auth extends FacadesAuth
{
    public static function forceUser(): User
    {
        $user = self::user();

        abort_unless($user instanceof User, Response::HTTP_UNAUTHORIZED);

        return $user;
    }

    public static function forceId(): int
    {
        $id = self::id();

        abort_unless(is_int($id), Response::HTTP_UNAUTHORIZED);

        return $id;
    }

    public static function id(): ?int
    {
        return Auth::check() ? (int) parent::id() : null;
    }

    public static function idOrAdmin(): int
    {
        return Auth::check() ? (int) parent::id() : User::ADMIN;
    }
}
