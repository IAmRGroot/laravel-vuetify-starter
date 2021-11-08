<?php

namespace App\Http\Controllers\Maintenance;

use App\Library\Maintenance\ControllerBase;
use App\Library\Maintenance\Fields\BelongsToManyField;
use App\Library\Maintenance\Fields\Password;
use App\Library\Maintenance\Fields\Text;
use App\Library\Maintenance\Fields\TimestampByField;
use App\Library\Maintenance\Fields\TimestampField;
use App\Models\Auth\User;
use Illuminate\Support\Collection;

class UserController extends ControllerBase
{
    protected string $model = User::class;

    public function getFields(): Collection
    {
        return collect([
            new Text('name'),
            new Text('email'),
            new Password('password'),
            new BelongsToManyField($this->instance, 'roles', 'name'),
            new TimestampByField($this->instance, 'updatedBy', 'name'),
            new TimestampField('updated_at'),
        ]);
    }
}
