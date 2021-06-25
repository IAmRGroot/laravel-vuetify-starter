<?php

namespace App\Library\Maintenance;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

abstract class ControllerBase extends Controller
{
    /**
     * @var class-string
     */
    protected string $model;

    protected bool $permissions       = false;
    protected string $permission_name = '_maintenance';

    protected Model $instance;
    protected Table $table;

    public function __construct()
    {
        $model_name     = $this->model;
        $this->instance = new $model_name();
    }

    public function routes(): void
    {
        Route::middleware($this->permissions ? "can:{$this->getName()}{$this->permission_name}" : [])
            ->prefix($this->getName())
            ->name("{$this->getName()}.")
            ->group(static function (): void {
                Route::get('', [static::class, 'get'])->name('get');
                Route::put('put', [static::class, 'put'])->name('put');
                Route::patch('{model}/patch', [static::class, 'patch'])->name('patch');
                Route::delete('{model}/delete', [static::class, 'delete'])->name('delete');
            });
    }

    /**
     * @return array<string, mixed>
     */
    public function vueData(): array
    {
        return [
            $this->getName() => $this->table->toArray(),
        ];
    }

    protected function getName(): string
    {
        return Str::plural(Str::lower(class_basename($this->model)));
    }

    /**
     * @return Collection|array<string, mixed>[]
     */
    public function get(): Collection
    {
        return $this->instance->all()->map(fn ($model) => $this->formatClosure()($model));
    }

    /**
     * @return array<string, mixed>
     */
    public function put(MaintenanceRequest $request): array
    {
        $new = $this->instance->newInstance([
            $request->data($this->table),
        ]);

        $new->save();

        return $this->formatClosure()($new);
    }

    /**
     * @return array<string, mixed>
     */
    public function patch(MaintenanceRequest $request, int $model): array
    {
        $existing = $this->instance->query()->findOrFail($model);

        $existing->fill($request->data($this->table));

        $existing->save();

        return $this->formatClosure()($existing);
    }

    protected function formatClosure(): Closure
    {
        return fn (Model $model): array => $model->only(($this->table->columns->map->column)->toArray());
    }
}
