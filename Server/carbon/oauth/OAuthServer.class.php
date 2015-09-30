<?php

/**
 * An OAuth wrapper specifically designed for Carbon
 */
abstract class OAuthServer extends OAuthProvider{
    /**
     * OAuth client name.
     * @var string 
     */
    protected $db = NULL;
    
    /**
     * OAuthServer constructor. At this stage does not do anything.
     */
    public function __construct($db){
        parent::__construct();
        $this->db = $db;
    }
    
    /**
     * Checks the request handles by the OAuthProvider.
     * @param type $uri
     * @throws Exception
     */
    public function checkRequest($uri = NULL){
        if($uri !== NULL){
            $this->checkOAuthRequest($uri);
        }
        else{
            $this->checkOAuthRequest();
        }
    }
    
    /**
     * Sets the consumer handler callback function.
     * @param string $callback Callback function name.
     */
    public function setConsumerHandlerCallback($callback){
        $this->consumerHandler(array($this, $callback));
    }
    
    /**
     * Sets the timestamp nonce handler callback function.
     * @param string $callback Callback function name.
     */
    public function setTimestampNonceHandlerCallback($callback){
        $this->timestampNonceHandler(array($this, $callback));
    }
    
    /**
     * Sets the verifier handler callback function.
     * @param string $callback Callback function name.
     */
    public function setVerifierHandlerCallback($callback){
        $this->tokenHandler(array($this, $callback));
    }
    
    /**
     * Sets the access token handler callback function.
     * @param string $callback Callback function name.
     */
    public function setAccessTokenHandlerCallback($callback){
        $this->tokenHandler(array($this, $callback));
    }
    
    /**
     * Sets whether this is the request token end point.
     * @param type $isRequestTokenEndPoint
     */
    public function setIsRequestTokenEndPoint($isRequestTokenEndPoint = true){
        $this->isRequestTokenEndpoint($isRequestTokenEndPoint);
    }
    
    /**
     * Gets the consumer key.
     * @param string $consumerKey Consumer key.
     * @throws Exception
     */
    public function getConsumerKey(){
        return $this->consumer_key;
    }
    
    /**
     * Sets the consumer key.
     * @throws Exception
     */
    public function setConsumerKey($consumerKey){
        $this->consumer_key = $consumerKey;
    }
    
    /**
     * Gets the consumer secret.
     * @param string $consumerSecret Consumer secret.
     * @throws Exception
     */
    public function getConsumerSecret(){
        return $this->consumer_secret;
    }
    
    /**
     * Set the consumer secret.
     * @throws Exception
     */
    public function setConsumerSecret($consumerSecret){
        $this->consumer_secret = $consumerSecret;
    }
    
    /**
     * Get the request token.
     * @param string $requestToken Request token.
     * @throws Exception
     */
    public function getRequestToken(){
        return $this->token;
    }
    
    /**
     * Sets the request token.
     * @throws Exception
     */
    public function setRequestToken($requestToken){
        $this->token = $requestToken;
    }
    
    /**
     * Gets the request token secret.
     * @param string $requestTokenSecret Request token secret.
     * @throws Exception
     */
    public function getRequestTokenSecret(){
        return $this->token_secret;
    }
    
    /**
     * Sets the access token secret.
     * @throws Exception
     */
    public function setRequestTokenSecret($requestTokenSecret){
        $this->token_secret = $requestTokenSecret;
    }
    
    /**
     * Gets the access token.
     * @param string $accessToken Access token.
     * @throws Exception
     */
    public function getAccessToken(){
        return $this->token;
    }
    
    /**
     * Sets the access token.
     * @throws Exception
     */
    public function setAccessToken($accessToken){
        $this->token = $accessToken;
    }
    
    /**
     * Gets the access token secret.
     * @param string $accessTokenSecret Access token secret.
     * @throws Exception
     */
    public function getAccessTokenSecret(){
        return $this->token_secret;
    }
    
    /**
     * Sets the access token secret.
     * @throws Exception
     */
    public function setAccessTokenSecret($accessTokenSecret){
        $this->token_secret = $accessTokenSecret;
    }
    
    /**
     * Gets the verifier.
     * @param string $verifier Verifier.
     * @throws Exception
     */
    public function getVerifier(){
        return $this->verifier;
    }
    
    /**
     * Sets the verifier.
     * @param string $verifier Verifier.
     * @throws Exception
     */
    public function setVerifier($verifier){
        $this->verifier = $verifier;
    }
    
    /**
     * The function that calls all the necessary checks to see of a request token
     * can be granted.
     */
    public abstract function grantRequestToken();
    
    /**
     * Authorises an application to access/link with a user's account.
     */
    public abstract function grantAuthorisation($user, $requestTokenTuple);
    
    /**
     * The function that generates a consumer key for the client.
     */
    public abstract function generateConsumerKey();
    
    /**
     * The function that generates a consumer secret for the client.
     */
    public abstract function generateConsumerSecret();
    
    /**
     * The function that generates a request token for the client.
     */
    public abstract function generateRequestToken();
    
    /**
     * The function that generates a request token secret for the client.
     */
    public abstract function generateRequestTokenSecret();
    
    /**
     * The function that generates a verifier for the client.
     */
    public abstract function generateVerifier();
    
    /**
     * The function that generates a access token for the client.
     */
    public abstract function generateAccessToken();
    
    /**
     * The function that generates a request token secret for the client.
     */
    public abstract function generateAccessTokenSecret();
    
    /**
     * The consumer handler callback function that needs to be implemented by the user.
     */
    public abstract function consumerHandlerCallback();
    
    /**
     * The timestamp nonce handler callback function that needs to be implemented by the user.
     */
    public abstract function timestampNonceHandlerCallback();
    
    /**
    public function setVerifier($verifier){
     */
    public abstract function verifierHandlerCallback();
    
    /**
     * The access token handler callback function that needs to be implemented by the user.
     */
    public abstract function accessTokenHandlerCallback();
    
    /**
     * The request token handler function that needs to be implemented by the user.
     */
    public abstract function requestTokenHandler();
    
    /**
     * Verifier handler function that needs to be implemented by the user.
     */
    public abstract function verifierHandler();
    
    /**
     * The access token handler function that needs to be implemented by the user.
     */
    public abstract function accessTokenHandler();
    
}
