<?php

/**
 * A wrapper for the PDO database handler.
 */
class PDOConnection extends PDO {

    /**
     * @var boolean Debug flag.
     */
    private $debug = NULL;

    /**
     * Enable debugging.
     */
    const DEBUG_ON = true;

    /**
     * Disable debugging.
     */
    const DEBUG_OFF = false;

    /**
     * PDOConnection constructor.
     * @param string $dsn Data Source Name.
     * @param string $user Database user. 
     * @param string $password Database user password.
     * @param boolean $debug Debug flag.
     * @throws PDOException PDOException instance.
     */
    public function __construct($dsn, $user, $password, $debug = PDOConnection::DEBUG_ON) {
        try {
            parent::__construct($dsn, $user, $password);
            if ($debug) {
                $this->setDebug($debug);
            }
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Debug flag getter.
     * @return boolean Debug flag.
     */
    public function getDebug() {
        return $this->debug;
    }

    /**
     * Debug flag setter.
     * @param boolean $debug Debug flag.
     */
    public function setDebug($debug) {
        $this->debug = $debug;

        if ($this->debug) {
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
    }

}
