<?php

require_once __DIR__ . '/OAuthClientKeys.class.php';
require_once __DIR__ . '/OAuthClientUrls.class.php';

/**
 * A configuration wrapper for the OAuthClient
 */
class OAuthClientConfig{
    /**
     * OAuthClientKeys instance.
     * @var OAuthClientKeys
     */
    public $keys = NULL;
    
    /**
     * OAuthClientUrls instance.
     * @var OAuthClientUrls
     */
    public $urls = NULL;
    
    /**
     * OAuthClientConfig constructor. Container for keys and url configs.
     * @param OAuthClientKeys $keys OAuthClientKeys instance.
     * @param OAuthClientUrls $urls OAuthClientUrls instance.
     */
    public function __construct(OAuthClientKeys $keys, OAuthClientUrls $urls){
        $this->keys = $keys;
        $this->urls = $urls;
    }
    
    /**
     * Gets the OAuth client keys configuration.
     * @return OAuthClientKeys
     */
    public function getKeys() {
        return $this->keys;
    }

    /**
     * Gets the OAuth client urls configuration.
     * @return OAuthClientUrls
     */
    public function getUrls() {
        return $this->urls;
    }

    /**
     * Sets the OAuth client keys.
     * @param OAuthClientKeys $keys OAuthClientKeys instance.
     */
    public function setKeys(OAuthClientKeys $keys) {
        $this->keys = $keys;
    }

    /**
     * Sets the OAuth client urls.
     * @param OAuthClientUrls $urls OAuthClientUrls instance.
     */
    public function setUrls(OAuthClientUrls $urls) {
        $this->urls = $urls;
    }
}
