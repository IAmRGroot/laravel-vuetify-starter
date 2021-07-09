<?php

namespace App\Library\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceRequest;
use App\Library\Maintenance\Fields\Field;
use App\Library\Maintenance\Fields\IdField;
use App\Library\Maintenance\Fields\RelationField;
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
                Route::get('empty', [static::class, 'empty'])->name('empty');
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
        return [
            'table'    => $this->getName(),
            'fields'   => $this->getFieldsWithId()->map->toArray(),
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
        return $this->instance->query()
            ->with($this->getRelations())
            ->get()
            ->map(fn ($model) => $this->formatClosure()($model));
    }

    /**
     * @return array<string, mixed>
     */
    public function empty(): array
    {
        return $this->formatClosure()($this->instance);
    }

    /**
     * @return array<string, mixed>
     */
    public function put(MaintenanceRequest $request): array
    {
        $new = $this->instance->newInstance([
            $request->data($this->getFieldsWithId()),
        ]);

        $new->save();

        return $this->formatClosure()($new->fresh($this->getRelations()));
    }

    /**
     * @return array<string, mixed>
     */
    public function patch(MaintenanceRequest $request, int $model): array
    {
        $existing = $this->instance->query()->findOrFail($model);

        $existing->fill($request->data($this->getFieldsWithId()));
        $existing->save();

        return $this->formatClosure()($existing->fresh($this->getRelations()));
    }

    /**
     * @return Collection|Field[]
     */
    private function getFieldsWithId(): Collection
    {
        $fields = $this->getFields();

        if (! $fields->contains(fn (Field $field): bool => $field->column === $this->instance->getKeyName())) {
            $fields->prepend(new IdField($this->instance->getKeyName()));
        }

        return $fields;
    }

    protected function formatClosure(): Closure
    {
        return function (Model $model): array {
            $data = $model->only(
                $this->getFieldsWithId()->map->column->toArray()
            );

            foreach ($model->getHidden() as $hidden) {
                if (key_exists($hidden, $data)) {
                    $data[$hidden] = null;
                }
            }

            return array_merge(
                $data,
                $model->getRelations(),
            );
        };
    }

    /**
     * @return string[]
     */
    protected function getRelations(): array
    {
        return $this->getFields()
            ->filter(fn (Field $field): bool => $field instanceof RelationField)
            ->values()
            ->map(fn (RelationField $field): string => $field->relation)
            ->toArray();
    }
}
