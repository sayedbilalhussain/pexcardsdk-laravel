<?php

namespace SayedBilalHussain\PexCardSdk\Services;
use Exception;
use phpDocumentor\Reflection\Types\Parent_;

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

    public function setHeader($authString = "")
    {
        $url = "Token";
        $headers = array();
        $headers['Content-Type'] = " application/json";
        $headers['Accept'] = "application/json";
        $headers['Authorization'] = $authString;
        parent::setHeader($headers); // TODO: Change the autogenerated stub
    }

    /**
     * Generate user token
     * @throws Exception
     */

    public function generateUserToken() {
        $data = $this->createFormParams([
            'username' => config('pex.key.ADMIN_USERNAME'),
            'password' => config('pex.key.ADMIN_PASSWORD'),
        ]);
        $authString = "basic ".base64_encode(config('pex.key.CLIENT_ID') . ':' . config('pex.key.CLIENT_SECRET'));
        $this->setHeader($authString) ;

        $this->makeRequest("Token", $data,'POST');
        $this->setTokenAfterRequest();
        return $this->getToken();
    }

    /**
     * Get All Created Tokens
     * @throws Exception
     */
    public function getAllTokens()
    {
        $authString = "basic ".base64_encode(config('pex.key.CLIENT_ID') . ':' . config('pex.key.CLIENT_SECRET'));
        $this->setHeader($authString);
        $this->makeRequest("Token/GetAuthTokens", array(),'GET');
        return $responseData = $this->getBody(true);
    }

    /**
     * Get Detail of all Tokens
     * @param string $token
     * @return mixed
     * @throws Exception
     */
    public function getTokenDetail($token = ""){
        $authString = "token ".$token;
        $this->setHeader($authString);
        try {
            $this->makeRequest("Token", array(), 'GET');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return $responseData = $this->getBody(true);
    }
    /**
     * Delete All Auth Tokens Logout
     */
    public function revokeTokens(): string
    {
        $tokens = $this->getAllTokens();
        foreach ($tokens as  $token){
            $authString = "token ".$token->Token;
            $this->setHeader($authString);
            $this->makeRequest("Token", array(),'DELETE');
        }
        return "successfully deleted";
    }

    /**
     * Delete  Auth Token Logout
     * @param $token
     * @return string
     * @throws Exception
     */
    public function revokeToken($token): string
    {
            $authString = "token ".$token;
            $this->setHeader($authString);
            $this->makeRequest("Token", array(),'DELETE');
            return "successfully deleted";
    }

    /**
     * Renew user token
     * @throws Exception
     */
    public function renewToken () {
        $url = 'Token/Renew';
        $data = array();
        $this->createHeader();
        $this->makeRequest($url, $data,'POST');
        $this->setTokenAfterRequest();
        return $this->getToken();
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
        if(!is_null($this->accessToken)){
            $headers['Authorization'] = "token " . $this->accessToken;
            parent::setHeader($headers);
        }
        else {
            throw new Exception('Token is missing');
        }
    }

    /**
     * Fund Card
     * @param null $cardId
     * @param null $amount
     * @throws Exception
     */

    public function fundCard($cardId = null,$amount = null){
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

    public function fundCardZero($cardId = null){
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
