<?php

namespace App\Http\Controllers\Maintenance;

use App\Library\Maintenance\ControllerBase;
use App\Library\Maintenance\Fields\BelongsToManyField;
use App\Library\Maintenance\Fields\Text;
use App\Models\Auth\Role;
use Illuminate\Support\Collection;

class RoleController extends ControllerBase
{
    protected string $model = Role::class;

    public function getFields(): Collection
    {
        return collect([
            new Text('name'),
            new BelongsToManyField($this->instance, 'permissions', 'name'),
        ]);
    }
}
