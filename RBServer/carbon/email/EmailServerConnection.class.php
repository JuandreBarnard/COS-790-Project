<?php

require_once __DIR__ . '/../library/PHPMailer/PHPMailerAutoload.php';

/**
 * A wrapper for the Email Server handler.
 */
abstract class EmailServerConnection {

    /**
     * @var Array Email server hosts.
     */
    protected $hosts = NULL;

    /**
     * @var int Email server port.
     */
    protected $port = NULL;

    /**
     * @var string Email server user. 
     */
    protected $user = NULL;

    /**
     * @var string Email server user password. 
     */
    protected $password = NULL;

    /**
     * @var string Email server security protocol. 
     */
    protected $security_protocol = NULL;
    
    /**
     * @var boolean Email server debug flag. 
     */
    protected $debug = NULL;

    /**
     * Enable debugging.
     */
    const DEBUG_ON = true;

    /**
     * Disable debugging.
     */
    const DEBUG_OFF = false;
    
    /**
     * Do not use secure transfer.
     */
    const SECURITY_PROTOCOL_NONE = '';
    
    /**
     * security_protocol using tls.
     */
    const SECURITY_PROTOCOL_TLS = 'tls';
    
    /**
     * security_protocol using tls.
     */
    const SECURITY_PROTOCOL_SSL = 'ssl';

    /**
     * Successful flag.
     */
    const SENDING_SUCCESSFUL = true;

    /**
     * Unsuccessful flag.
     */
    const SENDING_UNSUCCESSFUL = false;

    /**
     * EmailServerConnection constructor.
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

}
