<?php

namespace SayedBilalHussain\PexCardSdk\Services;

class PexService extends PexParent
{
    public function __construct()
    {
        parent::__construct();
    }
    public function event($name,$value){
        return $name."=>".$this->baseUrl ."=>".$value;
    }
}
?>
