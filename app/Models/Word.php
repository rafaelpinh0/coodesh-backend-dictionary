<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $word
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
    ];
}
