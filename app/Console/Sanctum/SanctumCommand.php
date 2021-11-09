<?php

namespace App\Console\Sanctum;

use App\Models\Auth\User;
use Illuminate\Console\Command;

abstract class SanctumCommand extends Command
{
    protected User $user;

    public function setUser(): void
    {
        $this->user = User::findOrFail($this->argument('user'));
    }
}
