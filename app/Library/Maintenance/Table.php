<?php

namespace App\Library\Maintenance;

use Illuminate\Support\Collection;

/**
 * @property Collection|Column[] $columns
 */
class Table
{
    public function __construct(
        public Collection $columns
    ) {
        $columns = collect();
    }

    /**
     * @return array<string, mixed>[]
     */
    public function toArray(): array
    {
        return $this->columns->map(fn (Column $column) => $column->toArray())->toArray();
    }
}
