<?php

namespace App\Traits;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \App\Models\Model
 */
trait HasTimestampsBy
{
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, self::CREATED_BY)->withTrashed(); // @phpstan-ignore-line
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, static::UPDATED_BY)->withTrashed(); // @phpstan-ignore-line
    }
}
