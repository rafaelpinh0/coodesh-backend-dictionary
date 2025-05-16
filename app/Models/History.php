<?php

namespace App\Models;

use App\Models\User;
use App\Models\Words\Word;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $word_id
 * @property Carbon $created_at
 * @property-read User $user
 * @property-read Word $word
 */

class History extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
