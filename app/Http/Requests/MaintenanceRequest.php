<?php

namespace App\Http\Requests;

use App\Library\Maintenance\Fields\BelongsToField;
use App\Library\Maintenance\Fields\Field;
use App\Library\Maintenance\Fields\Password;
use App\Library\Maintenance\Fields\Text;
use App\Library\Maintenance\Fields\TimestampField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class MaintenanceRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @param Collection|Field[] $fields
     *
     * @return array<string, mixed>
     */
    public function data(Collection $fields): array
    {
        $data    = $this->all();
        $to_skip = [];

        $mapped = $fields->mapWithKeys(static function (Field $field) use ($data, &$to_skip) {
            if ($field instanceof TimestampField) {
                $to_skip[] = $field->column;
            } elseif ($field instanceof BelongsToField) {
                return [$field->relation_key => $data[$field->relation][$field->relation_value]];
            } elseif ($field instanceof Password) {
                if (! $data[$field->column]) {
                    $to_skip[] = $field->column;
                } else {
                    $data[$field->column] = bcrypt($data[$field->column]);
                }
            } elseif (! $field instanceof Text) {
                $to_skip[] = $field->column;
            }

            return [$field->column => $data[$field->column] ?? null];
        })->except($to_skip);

        return $mapped->toArray();
    }
}
