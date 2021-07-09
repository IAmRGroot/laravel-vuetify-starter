<?php

namespace App\Library\Maintenance\Fields;

use App\Exceptions\IncorrectSetupException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class RelationField extends Field
{
    public string $relation_key;
    public string $relation_value;

    public function __construct(
        protected Model $instance,
        public string $relation,
        protected string $description_column,
    ) {
        parent::__construct($relation);

        $class_name = $instance::class;

        if (! method_exists($instance, $relation)) {
            throw new IncorrectSetupException("Relation {$relation} not found on model {$class_name}");
        }

        $relation_instance = $instance->{$relation}();

        if (! is_a($relation_instance, $this->getRelationClass())) {
            throw new IncorrectSetupException("Relation {$relation} on {$class_name} is not a {$this->getRelationClass()}");
        }

        $this->relation_key   = $this->getKey($relation_instance);
        $this->relation_value = $this->getRelationValue($relation_instance);
    }

    abstract protected function getRelationClass(): string;

    /**
     * @param Relation $relation
     *
     * @return string
     */
    abstract protected function getKey($relation): string;

    /**
     * @param Relation $relation
     *
     * @return string
     */
    abstract protected function getRelationValue($relation): string;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'relation'       => $this->relation,
                'relation_key'   => $this->relation_key,
                'relation_value' => $this->relation_value,
                'relation_text'  => $this->description_column,
            ],
        );
    }
}
