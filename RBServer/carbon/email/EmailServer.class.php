<?php

require_once __DIR__ . '/EmailServerConfig.class.php';

/**
 * A email server object that handles all email related information.
 */
abstract class EmailServer {

    /**
     * @var EmailServerConfig EmailServer configuration/settings.
     */
    protected $emailServerConfig = NULL;

    /**
     * EmailServer constructor.
     * @param EmailServerConfig $emailServerConfig EmailServer configuration.
     */
    public function __construct(EmailServerConfig $emailServerConfig) {
        $this->emailServerConfig = $emailServerConfig;
    }

    /**
     * @abstract Opens a connection to the email server.
     */
    public abstract function open();
}
