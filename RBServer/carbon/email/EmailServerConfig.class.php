<?php

/**
 * EmailServer configuration instance.
 */
class EmailServerConfig {

    /**
     * @var Array Email server hosts.
     */
    private $hosts = NULL;

    /**
     * @var int Email server port.
     */
    private $port = NULL;

    /**
     * @var string Email server user. 
     */
    private $user = NULL;

    /**
     * @var string Email server user password. 
     */
    private $password = NULL;

    /**
     * @var boolean Email server security protocol string. 
     */
    private $security_protocol = NULL;
    
    /**
     * @var boolean Email server debug flag. 
     */
    private $debug = NULL;

    /**
     * EmailServerConfig constructor.
     * @param Array $hosts Email server hosts.
     * @param int $port Email server port.
     * @param string $user Email server user. 
     * @param string $password Email server user password. 
     * @param string $security_protocol Email server security protocol.
     * @param boolean $debug Email server debug flag.
     */
    public function __construct(Array $hosts, $port, $user, $password, $security_protocol = EmailServerConnection::SECURITY_PROTOCOL_NONE, $debug = EmailServerConnection::DEBUG_ON) {
        $this->hosts = $hosts;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->security_protocol = $security_protocol;
        $this->debug = $debug;
    }

    /**
     * Host getter.
     * @return string Email server hosts.
     */
    public function getHosts() {
        return $this->hosts;
    }

    /**
     * Port getter.
     * @return int Email server port.
     */
    public function getPort() {
        return $this->port;
    }

    /**
     * User getter.
     * @return string Email server user.
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Password getter.
     * @return string Email server user password.
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Security protocol getter.
     * @return string Security protocol type.
     */
    public function getSecurityProtocol() {
        return $this->security_protocol;
    }
    
    /**
     * Debug flag getter.
     * @return boolean Email server debug flag.
     */
    public function getDebug() {
        return $this->debug;
    }

    /**
     * Email server hosts setter.
     * @param Array $hosts Email server hosts.
     */
    public function setHosts($hosts) {
        $this->hosts = $hosts;
    }

    /**
     * Email server port setter.
     * @param int $port Email server port
     */
    public function setPort($port) {
        $this->port = $port;
    }

    /**
     * Email server user setter.
     * @param string $user Email server user.
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Email server user password.
     * @param string $password Email server user password.
     */
    public function setPassword($password) {
        $this->password = $password;
    }
    
    /**
     * Email server Security protocol setter.
     * @param string $security_protocol Email server security protocol.
     */
    public function setSecurityProtocol($security_protocol) {
        $this->security_protocol = $security_protocol;
    }

    /**
     * Email server debug flag setter.
     * @param boolean $debug Email server debug flag.
     */
    public function setDebug($debug) {
        $this->debug = $debug;
    }

}
