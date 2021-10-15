<?php

namespace App\Traits;

use App\Facades\Auth;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \App\Models\Model
 */
trait HasTimestampsBy
{
    use HasTimestamps {
        setCreatedAt as protected originalSetCreatedAt;
        setUpdatedAt as protected originalSetUpdatedAt;
    }

    public function getCreatedByColumn(): string
    {
        return 'created_by';
    }

    public function getUpdatedByColumn(): string
    {
        return 'updated_by';
    }

    public function getTimestampUser(): int
    {
        return Auth::forceId();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getCreatedByColumn())->withTrashed();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getUpdatedByColumn())->withTrashed();
    }

    public function setCreatedAt($value)
    {
        $this->originalSetCreatedAt($value);

        if (! $this->isDirty($this->getCreatedByColumn())) {
            $this->setAttribute($this->getCreatedByColumn(), $this->getTimestampUser());
        }

        return $this;
    }

    public function setUpdatedAt($value)
    {
        $this->originalSetUpdatedAt($value);

        if (! $this->isDirty($this->getUpdatedByColumn())) {
            $this->setAttribute($this->getUpdatedByColumn(), $this->getTimestampUser());
        }

        return $this;
    }
}
