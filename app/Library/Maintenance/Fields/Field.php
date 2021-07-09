<?php

namespace App\Library\Maintenance\Fields;

use App\Enums\FieldType;

abstract class Field
{
    protected int $type         = FieldType::TEXT;
    protected bool $editable    = true;
    protected bool $visible     = true;

    public function __construct(
        public string $column
    ) {
    }

    public function visible(bool $visible = true): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function editable(bool $editable = true): self
    {
        $this->editable = $editable;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'      => $this->type,
            'value'     => $this->column,
            'text'      => $this->getText(),
            'visible'   => $this->visible,
            'editable'  => $this->editable,
        ];
    }

    protected function getText(): string
    {
        return (string) trans("database.column.{$this->column}");
    }
}
