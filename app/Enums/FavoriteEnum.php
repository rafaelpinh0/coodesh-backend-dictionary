<?php

namespace App\Enums;

enum FavoriteEnum: int
{
    case DEFAULT = 1;
    case FAVORITED = 2;
    case UNFAVORITED = 3;

    /**
     * @return bool
     */
    public function isFavorited(): bool
    {
        return $this === self::FAVORITED;
    }

    /**
     * @return bool
     */
    public function isUnfavorited(): bool
    {
        return $this === self::UNFAVORITED;
    }
}
