<?php

namespace App\Console\Sanctum;

use Illuminate\Console\Command;
use Laravel\Sanctum\Sanctum;

class DeleteToken extends Command
{
    protected $signature   = 'sanctum:delete {token_id}';
    protected $description = 'Deletes a token from a user';

    public function handle(): int
    {
        $token_id = $this->argument('token_id');
        $token    = Sanctum::$personalAccessTokenModel::findOrFail($token_id);

        $confirm = $this->ask('Are you sure? The token "' . $token->name . '" will not work anymore! [y/n]', 'n');

        if ('y' !== $confirm) {
            return 1;
        }

        $token->delete();

        $this->info('Deleted!');

        return 0;
    }
}
