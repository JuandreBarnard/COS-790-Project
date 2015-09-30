<?php

require_once __DIR__ . '/EmailServerConnection.class.php';

class SMTPEmailServerConnection extends EmailServerConnection {

    /**
     * SMTPEmailServerConnection constructor.
     * @param Array $hosts Email server connection hosts.
     * @param int $port Email server connection port.
     * @param string $user Email server connection user. 
     * @param string $password Email server connection user password. 
     * @param string $security_protocol Email server security protocol.
     * @param boolean $debug Email server connection debug flag.
     */
    public function __construct($hosts, $port, $user, $password, $security_protocol = EmailServerConnection::SECURITY_PROTOCOL_NONE, $debug = EmailServerConnection::DEBUG_ON) {
        parent::__construct($hosts, $port, $user, $password, $security_protocol, $debug);
    }

    /**
     * Converts the hosts array to a list of hosts in string format.
     * @param array $hosts Email server hosts.
     * @return string Hosts list in string format.
     */
    private function buildHosts(Array $hosts) {
        return implode(";", $hosts);
    }

    /**
     * Opens up a connection to the email server.
     * @return PHPMailer Mailer object.
     */
    public function getMailer() {
        $this->mailer = new PHPMailer();

        $this->mailer->isSMTP();

        $this->mailer->Host = $this->buildHosts($this->hosts);

        if ($this->user || $this->password) {
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->user;
            $this->mailer->Password = $this->password;
        }
        
        if($this->security_protocol != EmailServerConnection::SECURITY_PROTOCOL_NONE){
            $this->mailer->SMTPSecure = $this->security_protocol;
        }

        return $this->mailer;
    }

    /**
     * @TODO
     * Set and get debug
     */
}
