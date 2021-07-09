<?php

namespace App\Library\Maintenance\Fields;

use App\Enums\FieldType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BelongsToField extends RelationField
{
    protected int $type = FieldType::BELONGS_TO;

    protected function getRelationClass(): string
    {
        return BelongsTo::class;
    }

    /**
     * @param BelongsTo $relation
     *
     * @return string
     */
    protected function getKey($relation): string
    {
        return $relation->getForeignKeyName();
    }

    /**
     * @param BelongsTo $relation
     *
     * @return string
     */
    protected function getRelationValue($relation): string
    {
        return $relation->getOwnerKeyName();
    }
}
