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

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, self::DELETED_BY)->withTrashed(); // @phpstan-ignore-line
    }
}
