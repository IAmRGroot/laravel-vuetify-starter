<?php

namespace Tests\Feature;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @internal
 * @covers \App\Http\Controllers\Maintenance\RoleController
 * @covers \App\Http\Controllers\Maintenance\UserController
 * @covers \App\Http\Controllers\MaintenanceController
 */
class MaintenanceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testMaintenanceAuth(): User
    {
        $response = $this->get('async/maintenance');
        $response->assertUnauthorized();

        /** @var User $user */
        $user = User::factory()->make();
        $user->save();

        $this->actingAs($user);
        $response = $this->get('async/maintenance');
        $response->assertForbidden();

        $user->givePermissionTo(Permission::findByName('maintenance'));
        $this->actingAs($user);
        $response = $this->get('async/maintenance');
        $response->assertOk();

        return $user;
    }

    /**
     * @depends testMaintenanceAuth
     */
    public function testMaintenanceSetup(User $user): void
    {
        $this->actingAs($user);

        $maintenance_response = $this->get('async/maintenance');

        $tables = array_keys($this->getTableModels());

        foreach ($maintenance_response->json() as $index => $table_setup) {
            $maintenance_response->assertJsonPath("{$index}.table", $tables[$index])
                ->assertJson(fn (AssertableJson $json) => $json->whereType("{$index}.fields", 'array')
                ->whereType("{$index}.key_name", 'string')
            );
        }
    }

    /**
     * @depends testMaintenanceAuth
     */
    public function testMaintenanceGet(User $user): void
    {
        $this->actingAs($user);

        foreach (array_keys($this->getTableModels()) as $table) {
            $response = $this->get("async/maintenance/{$table}");
            $response->assertJsonCount(DB::table($table)->count());

            $response = $this->get("async/maintenance/{$table}/empty");
            $response->assertOk();
        }
    }

    /**
     * @depends testMaintenanceAuth
     */
    public function testMaintenancePut(User $user): void
    {
        $this->actingAs($user);

        /** @var Model $model */
        foreach ($this->getTableModels() as $table => $model) {
            $count = $model->query()->count();

            $response = $this->put("async/maintenance/{$table}", $model->getAttributes());
            $response->assertCreated();
            $this->assertDatabaseCount($table, $count + 1);
        }
    }

    /**
     * @depends testMaintenanceAuth
     */
    public function testMaintenancePatch(User $user): void
    {
        $this->actingAs($user);

        /** @var Model $model */
        foreach ($this->getTableModels() as $table => $model) {
            $model->save();
            $count = $model->query()->count();

            $response = $this->patch("async/maintenance/{$table}/{$model->getKey()}", $model->getAttributes());
            $response->assertOk();
            $response->assertJsonPath($model->getKeyName(), $model->getKey());
            $this->assertSame($model->query()->count(), $count);
        }
    }

    /**
     * @depends testMaintenanceAuth
     */
    public function testMaintenanceDelete(User $user): void
    {
        $this->actingAs($user);

        /** @var Model $model */
        foreach ($this->getTableModels() as $table => $model) {
            $model->save();
            $count = $model->query()->count();

            $response = $this->delete("async/maintenance/{$table}/{$model->getKey()}");
            $response->assertOk()
                ->assertJson(['message' => 'ok']);
            $this->assertSame($model->query()->count(), $count - 1);
        }
    }

    private function getTableModels(): array
    {
        return [
            'users' => User::factory()->make(),
            'roles' => Role::factory()->make(),
        ];
    }
}
