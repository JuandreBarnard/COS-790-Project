<?php

/**
 * OAuth URLs container.
 */
class OAuthClientUrls{
    /**
     * URL to which the token request is sent.
     * @var string
     */
    protected $requestRequestTokenUrl = NULL;
    
    /**
     * URL to which the authorisation is redirected.
     * @var string
     */
    protected $requestAuthorisationUrl = NULL;
    
    /**
     * URL to which the access token request is sent.
     * @var string 
     */
    protected $requestAccessTokenUrl = NULL;
    
    /**
     * URL to which the access token refreshed request is sent.
     * @var string 
     */
    protected $requestAccessTokenRefreshUrl = NULL;
    
    /**
     * URL to which the OAuth client is authenticated.
     * @var string 
     */
    protected $requestAuthenticationUrl = NULL;
    
    /**
     * URL to which the callback is redirected.
     * @var string 
     */
    protected $callbackUrl = NULL;
    
    /**
     * OAuthsUrls constructor. Sets the relevant URLs that are used by a OAuthClient.
     * @param string $requestRequestTokenUrl URL to the request token request handler.
     * @param string $requestAuthorisationUrl URL to the authorisation handler.
     * @param string $requestAccessTokenUrl URL to the access token request handler.
     * @param string $requestAccessTokenRefreshUrl URL to the access token refresh request handler.
     * @param string $requestAuthenticationUrl URL to to the authentication handler.
     * @param string $callbackUrl Callback URL.
     */
    public function __construct($requestRequestTokenUrl, $requestAuthorisationUrl, $requestAccessTokenUrl, $requestAccessTokenRefreshUrl, $requestAuthenticationUrl, $callbackUrl){
        $this->requestRequestTokenUrl = $requestRequestTokenUrl;
        $this->requestAuthorisationUrl = $requestAuthorisationUrl;
        $this->requestAccessTokenUrl = $requestAccessTokenUrl;
        $this->requestAccessTokenRefreshUrl = $requestAccessTokenRefreshUrl;
        $this->requestAuthenticationUrl = $requestAuthenticationUrl;
        $this->callbackUrl = $callbackUrl;
    }
    
    /**
     * Gets the request token URL.
     * @return string
     */
    function getRequestRequestTokenUrl() {
        return $this->requestRequestTokenUrl;
    }

    /**
     * Gets the request authorisation URL.
     * @return string
     */
    function getRequestAuthorisationUrl() {
        return $this->requestAuthorisationUrl;
    }

    /**
     * Gets the request access token URL.
     * @return string
     */
    function getRequestAccessTokenUrl() {
        return $this->requestAccessTokenUrl;
    }

    /**
     * Gets the request access token refresh URL.
     * @return string
     */
    function getRequestAccessTokenRefreshUrl() {
        return $this->requestAccessTokenRefreshUrl;
    }
    
    /**
     * Gets the authentication URL.
     * @return string
     */
    function getRequestAuthentication() {
        return $this->requestAuthenticationUrl;
    }
    
    /**
     * Gets the callback URL.
     * @return string
     */
    function getCallbackUrl() {
        return $this->callbackUrl;
    }

    /**
     * Sets the request token URL.
    }

    /**
     * Sets the request authorisation URL.
     * @param string $requestAuthorisationUrl URL to which the authorisation is redirected.
     */
    function setRequestAuthorisationUrl($requestAuthorisationUrl) {
        $this->requestAuthorisationUrl = $requestAuthorisationUrl;
    }

    /**
     * Sets the request access token URL.
     * @param string $requestAccessTokenUrl URL to which the access token refreshed request is sent.
     */
    function setRequestAccessTokenUrl($requestAccessTokenUrl) {
        $this->requestAccessTokenUrl = $requestAccessTokenUrl;
    }

    /**
     * Sets the request access token refresh URL.
     * @param string $requestAccessTokenRefreshUrl URL to which the access token refreshed request is sent.
     */
    function setRequestAccessTokenRefreshUrl($requestAccessTokenRefreshUrl) {
        $this->requestAccessTokenRefreshUrl = $requestAccessTokenRefreshUrl;
    }

    /**
     * Sets the authentication URL.
     * @param string $authentication URL to which the OAuth client is authenticated.
     */
    function setRequestAuthentication($authentication) {
        $this->authentication = $authentication;
    }
    
    /**
     * Sets the callback URL.
     * @param string $callbackUrl URL to which the callback is redirected.
     */
    function setCallbackUrl($callbackUrl) {
        $this->callbackUrl = $callbackUrl;
    }
}
