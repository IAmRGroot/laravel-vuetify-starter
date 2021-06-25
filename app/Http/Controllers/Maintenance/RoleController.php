<?php

namespace App\Http\Controllers\Maintenance;

use App\Library\Maintenance\Column;
use App\Library\Maintenance\ControllerBase;
use App\Library\Maintenance\Table;
use App\Models\Auth\Role;

class RoleController extends ControllerBase
{
    protected string $model     = Role::class;
    protected bool $permissions = true;

    public function __construct()
    {
        parent::__construct();

        $this->table = new Table(collect([
            Column::make('id'),
            Column::make('name'),
        ]));
    }
}
