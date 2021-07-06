<?php

namespace App\Library\Maintenance\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelationField extends Field
{
    public string $key;

    /**
     * @param Model $model 
     * @param string $relation 
     * @param string $description_column 
     */
    public function __construct(
        protected Model $model,
        public string $relation,
        protected string $description_column,
    ) {
        $relation_instance = $model->{$relation}();

        if ($relation_instance instanceof BelongsTo) {
            parent::__construct($relation_instance->getForeignKeyName());
            $this->key = $relation_instance->getOwnerKeyName();
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            ['value' => "{$this->column}.{$this->key}"],
        );
    }
}
