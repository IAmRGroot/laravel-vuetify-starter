<?php

namespace App\Traits;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \App\Models\Model
 */
trait HasTimestampsBy
{
    abstract public function getCreatedByColumn(): string;

    abstract public function getUpdatedByColumn(): string;

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getCreatedByColumn())->withTrashed();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getUpdatedByColumn())->withTrashed();
    }
}
