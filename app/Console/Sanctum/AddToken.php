<?php

namespace App\Console\Sanctum;

class AddToken extends SanctumCommand
{
    protected $signature   = 'sanctum:add {user} {name?}';
    protected $description = 'Adds a new token to a user';

    public function handle(): void
    {
        $this->setUser();

        $name = $this->argument('name');
        $name = (is_array($name) ? null : $name) ?? 'token_' . now()->toDateTimeString();

        $this->info($this->user->createToken($name)->plainTextToken);
    }
}
