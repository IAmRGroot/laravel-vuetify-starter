<?php

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Database\Migrations\Migration;

class CreatePermissions extends Migration
{
    public function up(): void
    {
        $permissions = [
            'maintenance',
            'users_maintenance',
            'roles_maintenance',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        User::findOrFail(User::ADMIN)->givePermissionTo(Permission::all());

        $this->createAdmin();
    }

    public function createAdmin(): void
    {
        $role = Role::query()->create(['name' => 'admin']);
        $role->permissions()->sync(Permission::all());

        User::findOrFail(User::ADMIN)->roles()->sync($role);
    }
}
