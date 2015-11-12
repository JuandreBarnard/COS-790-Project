<?php

require_once __DIR__ . '/DatabaseConfig.class.php';

/**
 * A database object that handles all db related information.
 */
abstract class Database {

    /**
     * @var DatabaseConfig Database configuration/settings.
     */
    protected $databaseConfig = NULL;

    /**
     * Database constructor.
     * @param DatabaseConfig $databaseConfig Database configuration.
     */
    public function __construct(DatabaseConfig $databaseConfig) {
        $this->databaseConfig = $databaseConfig;
    }

    /**
     * @abstract Generate a DSN (Data Source Name) string.
     */
    protected abstract function generateDSN();

    /**
     * @abstract Opens a connection to the database.
     */
    public abstract function open();
}
