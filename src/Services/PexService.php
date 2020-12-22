<?php

namespace SayedBilalHussain\PexCardSdk\Services;

class PexService
{
    public static function event(string $name,float $val): string
    {
         return $name.'-'.$val;
    }
}
?>
