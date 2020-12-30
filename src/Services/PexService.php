<?php

namespace SayedBilalHussain\PexCardSdk\Services;
use Exception;

class PexService extends PexParent
{
    private $userName = null;
    private $password = null;
    private $clientId = null;
    private $clientSecret = null;
    private $accessToken = null;

    public function __construct()
    {
        parent::__construct();

        $this->userName = config('pex.key.ADMIN_USERNAME');
        $this->password = config('pex.key.ADMIN_PASSWORD');

        if(is_null($this->userName) || is_null($this->password)){
            throw new Exception('Pex Admin username and password not set in config/pex');
        }

        $this->clientId = config('pex.key.CLIENT_ID');
        $this->clientSecret = config('pex.key.CLIENT_SECRET');
        if(is_null($this->clientId) || is_null($this->clientSecret)){
            throw new Exception('Pex Admin CLIENT_ID and CLIENT_SECRET not set in config/pex');
        }

    }

    /**
     * set access token
     */
    function setToken($token){
        $this->accessToken = $token;
    }

    /**
     * get access token
     */
    function getToken(){
        return $this->accessToken;
    }

    function createFormParams($data){
        return [
            'form_params'=>$data
        ];
    }


    /**
     * Generate user token
     */

    public function generate_user_token() {

        $data = $this->createFormParams([
            'username' => config('pex.key.ADMIN_USERNAME'),
            'password' => config('pex.key.ADMIN_PASSWORD'),
        ]);
        $authString = base64_encode(config('pex.key.CLIENT_ID') . ':' . config('pex.key.CLIENT_SECRET'));
        $url = "Token";
        $headers = array();
        $headers['Content-Type'] = " application/json";
        $headers['Accept'] = "application/json";
        $headers['Authorization'] = "basic " . $authString;
        $this->setHeader($headers) ;

        $this->makeRequest($url, $data,'POST');
        $this->setTokenAfterRequest();

    }

    /**
     * Renew user token
     */
    public function renew_token () {
        $url = 'Token/Renew';
        $data = array();
        $this->createHeader();
        $this->makeRequest($url, $data,'POST');
        $this->setTokenAfterRequest();
    }

    /**
     * setTokenAfterRequest
     */
    function setTokenAfterRequest(){
        $tokenData = $this->getBody(true);
        if(isset($tokenData->Token)){
            $this->accessToken = $tokenData->Token;
        }else{
            throw new Exception('Token Parameter missing');
        }

    }
    /**
     * create token headers
     */

    public function createHeader(){
        if(!is_null($this->access_token)){
            $headers['Authorization'] = "token " . $this->access_token;
            $this->setHeader($headers);
        }
        else {
            throw new Exception('Token is missing');
        }
    }

    /**
     * Fund Card
     */

    public function FundCard($cardId = null,$amount = null){
        if(is_null($cardId) || is_null($amount)){
            throw new Exception('CardID and Amount is required');
        }

        $url = 'Card/Fund/'.$cardId;
        $data = array();
        $data = $this->createFormParams([
                'Amount' => $amount
            ]
        );
        $this->createHeader();
        $this->makeRequest($url, $data,'POST');
        $response = $this->getBody();

    }

    /**
     * Fund Card Zero
     */

    public function FundCardZero($cardId = null){
        if(is_null($cardId) ){
            throw new Exception('CardID and Amount is required');
        }

        $url = 'Card/Zero/'.$cardId;
        $data = array();
        $this->createHeader();
        $this->makeRequest($url, $data,'POST');
        $response = $this->getBody();

    }

}
?>
