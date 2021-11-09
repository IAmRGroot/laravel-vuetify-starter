<?php

namespace App\Console\Sanctum;

class ReplaceTokens extends SanctumCommand
{
    protected $signature   = 'sanctum:replace {user} {name?}';
    protected $description = 'Removes all tokens and adds a new one';

    public function handle(): int
    {
        $this->setUser();

        $confirm = $this->ask('Are you sure? All existing tokens for this user will not work anymore! [y/n]', 'n');

        if ('y' !== $confirm) {
            return 1;
        }

        $this->user->tokens->each->delete();

        $this->call('sanctum:add', ['user' => $this->user->id, 'name' => $this->argument('name')]);

        return 0;
    }
}
