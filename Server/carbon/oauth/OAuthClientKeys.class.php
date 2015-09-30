<?php

/**
 * OAuth keys container.
 */
class OAuthClientKeys{
    /**
     * Key definers.
     */
    const CONSUMER_KEY = 0x01;
    const CONSUMER_SECRET = 0x02;
    const REQUEST_TOKEN = 0x03;
    const REQUEST_TOKEN_SECRET = 0x04;
    const VERIFIER = 0x05;
    const ACCESS_TOKEN = 0x06;
    const ACCESS_TOKEN_SECRET = 0x07;
    
    /**
     * Consumer key.
     * @var string 
     */
    protected $consumerKey = NULL;
    
    /**
     * Consumer secret.
     * @var string 
     */
    protected $consumerSecret = NULL;
    
    /**
     * Request token.
     * @var string 
     */
    protected $requestToken = NULL;
    
    /**
     * Request token secret.
     * @var type 
     */
    protected $requestTokenSecret = NULL;
    
    /**
     * Verifier.
     * @var type 
     */
    protected $verifier = NULL;
    
    /**
     * Access token.
     * @var string 
     */
    protected $accessToken = NULL;
    
    /**
     * Access token secret.
     * @var string 
     */
    protected $accessTokenSecret = NULL;
    
    /**
     * OAuthClientKeys constructor. Container for all OAuth keys.
     * @param string $consumerKey Consumer key.
     * @param string $consumerSecret Consumer secret.
     */
    public function __construct($consumerKey, $consumerSecret) {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }
    
    /**
     * Gets the consumer key.
     * @return string
     */
    function getConsumerKey() {
        return $this->consumerKey;
    }

    /**
     * Gets the consumer secret.
     * @return string
     */
    function getConsumerSecret() {
        return $this->consumerSecret;
    }

    /**
     * Gets the request token.
     * @return string
     */
    function getRequestToken() {
        return $this->requestToken;
    }

    /**
     * Gets the request token secret.
     * @return string
     */
    function getRequestTokenSecret() {
        return $this->requestTokenSecret;
    }
    
    /**
     * Gets the verifier.
     * @return string
     */
    function getVerifier() {
        return $this->verifier;
    }
    
    /**
     * Gets the access token.
     * @return string
     */
    function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * Gets the access token secret.
     * @return string
     */
    function getAccessTokenSecret() {
        return $this->accessTokenSecret;
    }

    /**
     * Sets the consumer key.
     * @param string $consumerKey Consumer key.
     */
    function setConsumerKey($consumerKey) {
        $this->consumerKey = $consumerKey;
    }

    /**
     * Sets the consumer secret.
     * @param string $consumerSecret Consumer secret.
     */
    function setConsumerSecret($consumerSecret) {
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * Sets the request token.
     * @param string $requestToken Request token.
     */
    function setRequestToken($requestToken) {
        $this->requestToken = $requestToken;
    }
    
    /**
     * Sets the request token secret.
     * @param string $requestTokenSecret Request token secret.
     */
    function setRequestTokenSecret($requestTokenSecret) {
        $this->requestTokenSecret = $requestTokenSecret;
    }

    /**
     * Sets the verifier.
     * @param string $verifier Verifier.
     */
    function setVerifier($verifier) {
        $this->verifier = $verifier;
    }
    
    /**
     * Sets the access token.
     * @param string $accessToken Access token.
     */
    function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }

    /**
     * Sets the access token secret.
     * @param string $accessTokenSecret Access token secret.
     */
    function setAccessTokenSecret($accessTokenSecret) {
        $this->accessTokenSecret = $accessTokenSecret;
    }
}

