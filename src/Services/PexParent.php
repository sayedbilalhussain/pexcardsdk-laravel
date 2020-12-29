<?php


namespace SayedBilalHussain\PexCardSdk\Services;
use Exception;

class PexParent
{
   public $baseUrl = null;
   protected $headers = array();
   protected $response = null;

   public function __construct()
   {
      if (!config("pex.key.API_URL")){
          throw new Exception('Please set API Url in config/pex first');
      }else{
          $this->baseUrl = config("pex.key.API_URL");
      }
   }
}
