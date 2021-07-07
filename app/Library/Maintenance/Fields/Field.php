<?php

namespace App\Library\Maintenance\Fields;

use App\Enums\FieldType;

abstract class Field
{
    protected bool $editable    = true;
    protected bool $visible     = true;
    protected string $component = 'TextInput';

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
            'type'      => FieldType::COLUMN,
            'value'     => $this->column,
            'text'      => $this->getText(),
            'visible'   => $this->visible,
            'editable'  => $this->editable,
            'component' => $this->component,
        ];
    }

    protected function getText(): string
    {
        return (string) trans("database.column.{$this->column}");
    }
}
