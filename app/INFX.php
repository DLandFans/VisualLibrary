<?php

namespace App;

class INFX
{
    private static $per_page = 10;

    public static function IsNullOrEmptyString($test)
    {
        return (!isset($test) || trim($test)==='');
    }

    public static function perPage() { return self::$per_page; }


}

