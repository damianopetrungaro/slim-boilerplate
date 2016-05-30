<?php

namespace App\Acme\Helpers;

class Str
{
    public static function random($length)
    {
        return substr(md5(rand()), 0, $length);
    }
}
