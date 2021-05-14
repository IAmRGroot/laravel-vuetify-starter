<?php

namespace App\Traits;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin BaseModel
 */
trait HasSoftDeleteBy
{
    use SoftDeletes;

    /**
     * @return BelongsTo
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, self::DELETED_BY)->withTrashed();
    }
}
