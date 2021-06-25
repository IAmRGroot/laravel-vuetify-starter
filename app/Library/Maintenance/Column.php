<?php

namespace App\Library\Maintenance;

class Column
{
    protected bool $editable = true;
    protected bool $visable  = false;

    public function __construct(
        public string $column
    ) {
    }

    /**
     * @see Column::__construct
     *
     * @param mixed $args
     *
     * @return Column
     */
    public static function make(...$args): self
    {
        return new self(...$args);
    }

    public function visable(bool $visable = true): self
    {
        $this->visable = $visable;

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
            'value'    => $this->column,
            'text'     => $this->getText(),
            'visable'  => $this->visable,
            'editable' => $this->editable,
        ];
    }

    protected function getText(): string
    {
        return (string) trans("database.columns.{$this->column}");
    }
}
