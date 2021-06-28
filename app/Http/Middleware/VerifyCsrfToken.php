<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as IlluminateVerifyCsrfToken;

class VerifyCsrfToken extends IlluminateVerifyCsrfToken
{
    /**
     * {@inheritdoc}
     */
    protected function getTokenFromRequest($request)
    {
        $token = parent::getTokenFromRequest($request);

        if (! $token && is_string($request->cookie('XSRF-TOKEN'))) {
            $token = $request->cookie('XSRF-TOKEN');
        }

        return $token;
    }
}
