<?php

namespace App\Lib;

class Utils
{
    public static function getUserId(): array|string|null
    {
        return request()->header('X-USER-ID');
    }
}
