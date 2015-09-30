<?php

/**
 * Database configuration instance.
 */
class DatabaseConfig {

    /**
     * @var string Database host/location. 
     */
    private $host = NULL;

    /**
     * @var int Connection port.
     */
    private $port = NULL;

    /**
     * @var string Database name. 
     */
    private $database = NULL;

    /**
     * @var string Database user. 
     */
    private $user = NULL;

    /**
     * @var string Database user password.
     */
    private $password = NULL;

    /**
     * @var Array Stores db paramaters. 
     */
    private $parameters = NULL;
    
    /**
     * @var boolean Database debug flag.
     */
    private $debug = NULL;
    
    /**
     * DatabaseConfig constructor.
     * @param string $host Database host/location.
     * @param int $port Connection port.
     * @param string $database Database name.
     * @param string $user Database user.
     * @param string $password Database user password.
     * @param boolean $debug Database debug flag.
     */
    public function __construct($host, $port, $database, $user, $password, Array $parameters = NULL, $debug = PDOConnection::DEBUG_ON) {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->parameters = $parameters;
        $this->debug = $debug;
    }

    /**
     * Host getter.
     * @return string Database host/location.
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Port getter.
     * @return int Database connection port.
     */
    public function getPort() {
        return $this->port;
    }

    /**
     * Database name getter.
     * @return string Database name.
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * Database user getter.
     * @return Database user.
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Database password getter.
     * @return string Database password.
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Parameters getter.
     * @return Array paramaters.
     */
    public function getParamerers() {
        return $this->parameters;
    }
    
    /**
     * Database debug flag getter.
     * @return boolean Database debug flag.
     */
    public function getDebug() {
        return $this->debug;
    }

    /**
     * Database host setter.
     * @param string $host Database host/location.
     */
    public function setHost($host) {
        $this->host = $host;
    }

    /**
     * Database connection port setter.
     * @param int $port Database connection port.
     */
    public function setPort($port) {
        $this->port = $port;
    }

    /**
     * Database name setter.
     * @param string $database Database name.
     */
    public function setDatabase($database) {
        $this->database = $database;
    }

    /**
     * Database user setter.
     * @param string $user Database user.
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Database user password setter.
     * @param string $password Database user password.
     */
    public function setPassword($password) {
        $this->password = $password;
    }
    
    /**
     * Parameters setter.
     * @param $parameters Parameters.
     */
    public function setParamerers($parameters) {
        $this->parameters = $parameters;
    }

    /**
     * Database debug flag setter.
     * @param boolean $debug Database debug flag.
     */
    public function setDebug($debug) {
        $this->debug = $debug;
    }

}
