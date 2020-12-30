<?php


namespace SayedBilalHussain\PexCardSdk\Services;

use GuzzleHttp;
use Exception;
use GuzzleHttp\Exception\ClientException;
;


class PexParent
{
   public $baseUrl = null;

   public function __construct()
   {
      if (!config("pex.key.API_URL")){
          throw new Exception('Please set API Url in config/pex first');
      }else{
          $this->baseUrl = config("pex.key.API_URL");
      }
   }


    public function makeRequest($url = '',$data = array(),$request = 'GET'){
        $client = new GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
//            'debug' => true,
            'headers' => $this->headers,
        ]);
        try {
            $res = $client->request($request, $url,$data);
        } catch (ClientException $e) {
            throw new Exception($e->getResponse()->getBody(true));
        }
        $this->response = $res;
    }

    /**
     * set header values for guzzle
     */

    public function setHeader($headers = array()){
        $this->headers = $headers;
    }

    /**
     * get header values
     */
    public function getHeader(){
        return $this->headers;
    }

    /**
     * get body of response
     */

    public function getBody($json = false){
        if(is_null($this->response))
            throw new Exception('Curl request was not initated');
        if($json)
            return json_decode($this->response->getBody());
        else {
            return $this->response->getBody();
        }
    }
}

