<?php

namespace App\Traits;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin \App\Models\Model
 */
trait HasSoftDeleteBy
{
    use SoftDeletes;

    abstract public function getDeletedByColumn(): string;

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getDeletedByColumn())->withTrashed();
    }
}
