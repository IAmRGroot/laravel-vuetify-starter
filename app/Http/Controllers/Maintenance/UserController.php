<?php

namespace App\Http\Controllers\Maintenance;

use App\Library\Maintenance\ControllerBase;
use App\Library\Maintenance\Fields\Email;
use App\Library\Maintenance\Fields\Password;
use App\Library\Maintenance\Fields\Text;
use App\Models\Auth\User;
use Illuminate\Support\Collection;

class UserController extends ControllerBase
{
    protected string $model     = User::class;

    public function getFields(): Collection
    {
        return collect([
            Text::make('name'),
            Email::make('email'),
            Password::make('password'),
        ]);
    }
}
