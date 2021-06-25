<?php

namespace App\Library\Maintenance;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequest extends FormRequest
{
    /**
     * @param Table $table
     *
     * @return array<string, mixed>
     */
    public function data(Table $table): array
    {
        return $this->only($table->columns->map->column);
    }
}
