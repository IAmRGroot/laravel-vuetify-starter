<?php

namespace App\Library\Maintenance;

use App\Library\Maintenance\Fields\Field;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class MaintenanceRequest extends FormRequest
{
    /**
     * @param Collection|Field[] $fields
     *
     * @return array<string, mixed>
     */
    public function data(Collection $fields): array
    {
        return $this->only($fields->map->column);
    }
}
