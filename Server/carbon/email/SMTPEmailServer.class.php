<?php

require_once __DIR__ . '/EmailServer.class.php';
require_once __DIR__ . '/SMTPEmailServerConnection.class.php';

/**
 * An implementation of EmailServer that uses runs on SMTP.
 */
class SMTPEmailServer extends EmailServer {

    /**
     * Default port.
     */
    const DEFAULT_PORT = 25;
    
    /**
     * SMTPEmailServer constructor.
     * @param EmailServerConfig $emailServerConfig EmailServer configuration.
     */
    public function __construct(EmailServerConfig $emailServerConfig) {
        parent::__construct($emailServerConfig);
    }

    /**
     * Opens up a email_server connection.
     * @return EmailServerConnection EmailServer PDO connection.
     */
    public function open() {
        $hosts = $this->emailServerConfig->getHosts();
        $port = $this->emailServerConfig->getPort();
        $user = $this->emailServerConfig->getUser();
        $password = $this->emailServerConfig->getPassword();
        $security_protocol = $this->emailServerConfig->getSecurityProtocol();
        $debug = $this->emailServerConfig->getDebug();

        return new SMTPEmailServerConnection($hosts, $port, $user, $password, $security_protocol, $debug);
    }

}
