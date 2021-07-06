<?php

namespace App\Library\Maintenance;

use App\Http\Controllers\Controller;
use App\Library\Maintenance\Fields\Field;
use App\Library\Maintenance\Fields\IdField;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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

    public function __construct()
    {
        $model_name     = $this->model;
        $this->instance = new $model_name();
    }

    /**
     * @return Collection|Field[]
     */
    abstract protected function getFields(): Collection;

    public function routes(): void
    {
        Route::middleware($this->permissions ? "can:{$this->getName()}{$this->permission_name}" : [])
            ->prefix($this->getName())
            ->name("{$this->getName()}.")
            ->group(static function (): void {
                Route::get('', [static::class, 'get'])->name('get');
                Route::put('', [static::class, 'put'])->name('put');
                Route::patch('{model}', [static::class, 'patch'])->name('patch');
                Route::delete('{model}', [static::class, 'delete'])->name('delete');
            });
    }

    /**
     * @return array<string, mixed>
     */
    public function vueData(): array
    {
        return[
            'table' => $this->getName(),
            'fields'   => $this->getAllFields()->map->toArray(),
            'key_name' => $this->instance->getKeyName(),
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
            $request->data($this->getAllFields(false)),
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

        $existing->fill($request->data($this->getAllFields(false)));

        $existing->save();

        return $this->formatClosure()($existing);
    }

    /**
     * @return Collection|Field[]
     */
    private function getAllFields(bool $include_primary_key = true): Collection
    {
        $fields = $this->getFields();

        if (
            $include_primary_key
            && ! $fields->contains(fn (Field $field): bool => $field->column === $this->instance->getKeyName())
        ) {
            $fields->prepend(new IdField($this->instance->getKeyName()));
        }

        return $fields;
    }

    protected function formatClosure(): Closure
    {
        return fn (Model $model): array => Arr::only(
            $model->toArray(),
            ($this->getAllFields()->map->column)->toArray()
        );
    }
}
