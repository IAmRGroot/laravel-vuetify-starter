<?php

namespace App\Models;

use App\Exceptions\RelationNotEagerLoadedException;
use App\Facades\Auth;
use App\Traits\HasTimestampsBy;
use App\Traits\SerializeDateWithDefaultTimezone;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;

abstract class Model extends EloquentModel
{
    use SerializeDateWithDefaultTimezone;

    public function getCreatedByColumn(): string
    {
        return 'created_by';
    }

    public function getUpdatedByColumn(): string
    {
        return 'updated_by';
    }

    public function getDeletedByColumn(): string
    {
        return 'deleted_by';
    }

    // protected $connection = 'mysql';
    protected $guarded    = [];

    /**
     * Throws exception if relations are not loaded.
     *
     * @param string[]|string $relations
     * @param bool            $check_value
     *
     * @throws RelationNotEagerLoadedException
     */
    public function forceRelationsLoaded(array | string $relations, bool $check_value = false): void
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
        return $this->{$relation} instanceof self
            || ($this->{$relation} instanceof Collection && $this->{$relation}->count() > 0);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($value)
    {
        parent::setCreatedAt($value);

        if ($this->hasTimestampsBy()) {
            $this->setAttribute($this->getCreatedByColumn(), Auth::idOrAdmin());
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($value)
    {
        parent::setUpdatedAt($value);

        if ($this->hasTimestampsBy()) {
            $this->setAttribute($this->getUpdatedByColumn(), Auth::idOrAdmin());
        }

        return $this;
    }

    protected function hasTimestampsBy(): bool
    {
        return class_uses_recursive($this)[HasTimestampsBy::class] ?? false;
    }
}
