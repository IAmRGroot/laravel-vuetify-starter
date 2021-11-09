<?php

namespace App\Console\Sanctum;

use App\Models\Auth\PersonalAccessToken;
use Illuminate\Support\Arr;

class ViewTokens extends SanctumCommand
{
    protected $signature   = 'sanctum:view {user}';
    protected $description = 'View tokens from a user';

    public function handle(): void
    {
        $this->setUser();

        $headers = ['id', 'name', 'abilities', 'last_used_at', 'created_at', 'updated_at'];

        $this->table($headers, $this->user->tokens->map(fn (PersonalAccessToken $token) => array_merge(
            Arr::only($token->toArray(), $headers),
            ['abilities' => implode(', ', $token->abilities ?? [])]
        )));
    }
}
