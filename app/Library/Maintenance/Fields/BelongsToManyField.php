<?php

namespace App\Library\Maintenance\Fields;

use App\Enums\FieldType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BelongsToManyField extends RelationField
{
    protected string $component = 'BelongsToManyInput';

    protected function getRelationClass(): string
    {
        return BelongsToMany::class;
    }

    /**
     * @param BelongsToMany $relation
     *
     * @return string
     */
    protected function getKey($relation): string
    {
        return $relation->getForeignPivotKeyName();
    }

    /**
     * @param BelongsToMany $relation
     *
     * @return string
     */
    protected function getRelationValue($relation): string
    {
        return $relation->getParentKeyName();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'type' => FieldType::BELONGS_TO_MANY,
            ],
        );
    }
}
