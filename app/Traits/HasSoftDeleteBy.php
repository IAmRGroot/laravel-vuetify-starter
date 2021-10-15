<?php

namespace App\Traits;

use App\Facades\Auth;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin \App\Models\Model
 */
trait HasSoftDeleteBy
{
    use SoftDeletes {
        restore as originalRestore;
        runSoftDelete as originalRunSoftDelete;
    }

    public function getDeletedByColumn(): string
    {
        return 'deleted_by';
    }

    public function getSoftDeleteUser(): int
    {
        return Auth::forceId();
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getDeletedByColumn())->withTrashed();
    }

    public function restore(): ?bool
    {
        if (! $this->isDirty($this->getDeletedByColumn())) {
            $this->setAttribute($this->getDeletedByColumn(), null);
        }

        return $this->originalRestore();
    }

    public function runSoftDelete(): void
    {
        if (! $this->isDirty($this->getDeletedByColumn())) {
            $this->setAttribute($this->getDeletedByColumn(), $this->getSoftDeleteUser());
        }

        $this->originalRunSoftDelete();
    }
}
