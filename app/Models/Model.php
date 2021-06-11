<?php

namespace App\Models;

use App\Exceptions\RelationNotEagerLoadedException;
use App\Traits\SerializeDateWithDefaultTimezone;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;

abstract class Model extends EloquentModel
{
    use SerializeDateWithDefaultTimezone;

    public const CREATED_BY = 'created_by';
    public const UPDATED_BY = 'updated_by';
    public const DELETED_BY = 'deleted_by';

    protected $connection = 'mysql';

    /**
     * Throws exception if relations are not loaded.
     *
     * @param string[]|string $relations
     * @param bool            $check_value
     *
     * @throws RelationNotEagerLoadedException
     */
    public function forceRelationsLoaded(array|string $relations, bool $check_value = false): void
    {
        if (is_array($relations)) {
            foreach ($relations as $relation) {
                $this->forceRelationLoadedRecursive($relation, $check_value);
            }

            return;
        }

        $this->forceRelationLoadedRecursive($relations, $check_value);
    }

    /**
     * Throws exception if relation is not loaded.
     * Only checks first element if relation is a collection.
     *
     * @param string $relation
     * @param bool   $check_value
     *
     * @throws RelationNotEagerLoadedException
     */
    private function forceRelationLoadedRecursive(string $relation, bool $check_value = false): void
    {
        if ('' === $relation) {
            return;
        }

        // if not nested.
        if (! str_contains($relation, '.')) {
            if (! $this->relationLoaded($relation)) {
                throw new RelationNotEagerLoadedException('Relation is not eager loaded: ' . $relation);
            }
            if ($check_value && ! $this->relationHasValue($relation)) {
                throw new RelationNotEagerLoadedException('Relation has no value: ' . $relation);
            }

            return;
        }

        // if nested.
        $relations      = explode('.', $relation);
        $first_relation = array_shift($relations);

        $this->forceRelationLoadedRecursive($first_relation, $check_value);

        $first_relation  = $this->{$first_relation};
        $other_relations = implode('.', $relations);

        if ($first_relation instanceof Collection) {
            $first_relation = $first_relation->first();
        }

        if (! $first_relation instanceof self) {
            return;
        }

        $first_relation->forceRelationLoadedRecursive($other_relations, $check_value);
    }

    private function relationHasValue(string $relation): bool
    {
        return $this->{$relation} instanceof self ||
            ($this->{$relation} instanceof Collection && $this->{$relation}->count() > 0);
    }
}
