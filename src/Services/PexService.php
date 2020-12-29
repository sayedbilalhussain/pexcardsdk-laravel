<?php

namespace SayedBilalHussain\PexCardSdk\Services;

class PexService extends PexParent
{

    private static $url ;

    public function __construct()
    {
        parent::__construct();
    }
    public static function event($name,$value){
        return $name.$value;
    }
}
?>
