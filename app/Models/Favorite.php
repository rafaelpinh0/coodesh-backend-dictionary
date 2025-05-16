<?php

namespace App\Models;

use App\Enums\FavoriteEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $word_id
 * @property FavoriteEnum $status
 * @property Carbon $created_at
 * @property-read User $user
 * @property-read Word $word
 */

class Favorite extends Model
{
    use SoftDeletes;

    protected $casts = [
        'status' => FavoriteEnum::class,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
