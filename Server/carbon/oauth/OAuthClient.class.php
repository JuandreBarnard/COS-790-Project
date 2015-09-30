<?php

require_once __DIR__ . '/OAuthClientConfig.class.php';

/**
 * An OAuth wrapper specifically designed for Carbon
 */
abstract class OAuthClient extends OAuth{  
    /**
     * OAuth client name.
     * @var string 
     */
    private $name = NULL;
    
    /**
     * OAuth client details.
     * @var string 
     */
    private $details = NULL;
    
    /**
     * OAuth client signature.
     * @var string 
     */
    private $signature = NULL;
    
    /**
     * OAuth client timestamp.
     * @var string 
     */
    private $timestamp = NULL;
    
    /**
     * OAuth client nonce.
     * @var string 
     */
    private $nonce = NULL;
    
    /**
     * OAuth client version.
     * @var string 
     */
    private $version = NULL;
    
    /**
     * OAuth client configuration.
     * @var OAuthClientConfig 
     */
    public $config = NULL;
    
    /**
     * OAuthClient constructor. Assigns the OAuth client configuration.
     * @param string $name OAuth client name.
     * @param string $details OAuth client details.
     * @param string $version OAuth client version.
     * @param OAuthClientConfig $config OAuthClientConfig instance.
     */
    public function __construct(OAuthClientConfig $config){
        $this->config = $config;
        $consumerKey = $this->config->keys->getConsumerKey();
        $consumerSecret = $this->config->keys->getConsumerSecret();
        parent::__construct($consumerKey, $consumerSecret);
    }
    
    /**
     * Gets a request token and sets it accordingly.
     * @return Array An array containing the response from the OAuth provider.
     */
    public abstract function getRequestTokenFromServer();
    
    /**
     * Redirects the user to the authorisation page.
     * @throws Exception
     */
    public abstract function getAuthorisationFromServer();
    
    /**
     * Request access token which can be used to access resources.
     * @return Array An array containing the response from the OAuth provider.
     * @throws Exception
     */
    public abstract function getAccessTokenFromServer();
    
    /**
     * Gets a resource from the OAuth provider.
     * @param string $url Resource URL.
     * @param Array $parameters Parameters to pass to the API/Service.
     * @return Array Response from OAuth provider.
     * @throws Exception
     */
    public abstract function getResourceFromServer($url, $parameters = NULL);
    
    /**
     * Implodes http url query.
     * @param type $response
     * @return type
     */
    public abstract function formulateResponse($response);
    
    /**
     * Generates the nonce.
     * @return string
     */
    public abstract function generateNonce($timestamp);
    
    /**
     * Generates a unix form timestamp.
     * @return int
     */
    public abstract function generateTimestamp();
    
    /**
     * Gets OAuth client name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets OAuth client details.
     * @return string
     */
    public function getDetails() {
        return $this->details;
    }
    
    /**
     * Gets the OAuth client signature.
     * @return string
     */
    public function getSignature() {
        return $this->signature;
    }

    /**
     * Gets the OAuth client timestamp;
     * @return string
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * Gets the OAuth client nonce.
     * @return string
     */
    public function getNonce() {
        return $this->nonce;
    }

    /**
     * Gets the OAuth client version.
     * @return type
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Gets OAuth client config.
     * @return OAuthClientConfig
     */
    public function getConfig() {
        return $this->config;
    }
    
    /**
     * Sets OAuth client name.
     * @param string $name OAuth client name.
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Sets OAuth client details.
     * @param string $details OAuth client details.
     */
    public function setDetails($details) {
        $this->details = $details;
    }
    
    /**
     * Sets the OAuth client signature.
     * @param string $signature OAuth client signature.
     */
    public function setSignature($signature) {
        $this->signature = $signature;
    }

    /**
     * Sets the OAuth client timestamp.
     * @param string $timestamp OAuth client timestamp.
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    /**
     * Sets the OAuth client nonce.
     * @param string $nonce OAuth client nonce.
     */
    public function setNonce($nonce) {
        $this->nonce = $nonce;
    }

    /**
     * Sets the OAuth client version.
     * @param string $version OAuth client version.
     */
    public function setVersion($version) {
        $this->version = $version;
    }

    /**
     * Sets OAuth client config.
     * @param OAuthClientConfig $config OAuth client config instance.
     */
    public function setConfig(OAuthClientConfig $config) {
        $this->config = $config;
    }
    
    public function getKey($keyType){
        $keys = $this->config->keys;
        
        switch($keyType){
            case OAuthClientKeys::CONSUMER_KEY: return $keys->getConsumerKey();
            case OAuthClientKeys::CONSUMER_SECRET: return $keys->getConsumerSecret();
            case OAuthClientKeys::REQUEST_TOKEN: return $keys->getRequestToken();
            case OAuthClientKeys::REQUEST_TOKEN_SECRET: return $keys->getRequestTokenSecret();
            case OAuthClientKeys::VERIFIER: return $keys->getVerifier();
            case OAuthClientKeys::ACCESS_TOKEN: return $keys->getAccessToken();
            case OAuthClientKeys::ACCESS_TOKEN_SECRET: return $keys->getAccessTokenSecret();
            default: return NULL;
        }
    }
    
    public function setKey($keyType, $value){
        $keys = $this->config->keys;
        
        switch($keyType){
            case OAuthClientKeys::CONSUMER_KEY: return $keys->setConsumerKey($value);
            case OAuthClientKeys::CONSUMER_SECRET: return $keys->setConsumerSecret($value);
            case OAuthClientKeys::REQUEST_TOKEN: return $keys->setRequestToken($value);
            case OAuthClientKeys::REQUEST_TOKEN_SECRET: return $keys->setRequestTokenSecret($value);
            case OAuthClientKeys::VERIFIER: return $keys->setVerifier($value);
            case OAuthClientKeys::ACCESS_TOKEN: return $keys->setAccessToken($value);
            case OAuthClientKeys::ACCESS_TOKEN_SECRET: return $keys->setAccessTokenSecret($value);
            default: return NULL;
        }
    }
}
