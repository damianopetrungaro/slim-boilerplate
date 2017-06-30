<?php declare(strict_types=1);

namespace App\Acme\Helpers;

class Str
{
    /**
     * Return a random string by a specific length
     *
     * @param int $length
     *
     * @return string
     */
    public static function random(int $length): string
    {
        return substr(md5((string)mt_rand()), 0, $length);
    }
}
