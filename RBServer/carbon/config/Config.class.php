<?php

require_once __DIR__ . '/../databases/Database.class.php';
require_once __DIR__ . '/../functions/converters.functions.php';

/**
 * Stores the application's configuration in an instance.
 */
class Config {

    /**
     * @var Array An array of databases that the application uses.
     */
    private $databases = NULL;

    /**
     * @var Array An array of email servers that the application uses.
     */
    private $emailServers = NULL;
    
    /**
     * @var Array An array of themes that the site uses. 
     */
    private $themes = NULL;

    /**
     * The application's default database.
     * @var D extends Database Database instance.
     */
    private $defaultDatabase = NULL;

    /**
     * The application's default email server.
     * @var E extends EmailServer EmailServer instance.
     */
    private $defaultEmailServer = NULL;

    /**
     * The application's default theme.
     * @var Theme Theme instance.
     */
    private $defaultTheme = NULL;

    /**
     * Adds a new database configuration to the application.
     * @param string $identifier Database unique identifier.
     * @param D extends Database $database Database instance.
     */
    public function addDatabase($identifier, Database $database) {
        $this->databases[$identifier] = $database;
    }

    /**
     * Gets a database by a unique identifier.
     * @param string $identifier Database unique identifier.
     * @return D extends Database
     */
    public function getDatabase($identifier) {
        return $this->databases[$identifier];
    }
    
    /**
     * Gets a all the databases.
     * @return D extends Database
     */
    public function getDatabases() {
        return $this->databases;
    }

    /**
     * Adds a new email server configuration to the application.
     * @param string $identifier EmailServer unique identifier.
     * @param E extends EmailServer $emailServer Database instance.
     */
    public function addEmailServer($identifier, EmailServer $emailServer) {
        $this->emailServers[$identifier] = $emailServer;
    }

    /**
     * Gets an email server by a unique identifier.
     * @param string $identifier Email server unique identifier.
     * @return E extends EmailServer
     */
    public function getEmailServer($identifier) {
        return $this->emailServers[$identifier];
    }
    
    /**
     * Gets all the email servers.
     * @return E extends EmailServer
     */
    public function getEmailServers() {
        return $this->emailServers;
    }

    /**
     * Adds a new theme configuration to the application.
     * @param string $identifier Theme unique identifier.
     * @param Theme $theme Theme instance.
     */
    public function addTheme($identifier, Theme $theme) {
        $this->themes[$identifier] = $theme;
    }

    /**
     * Gets a theme by a unique identifier.
     * @param string $identifier Theme unique identifier.
     * @return D extends Theme
     */
    public function getTheme($identifier) {
        return $this->themes[$identifier];
    }
    
    /**
     * Gets all the themes.
     * @return D extends Theme
     */
    public function getThemes() {
        return $this->themes;
    }

    /**
     * Gets the default database.
     * @return D extends Database Default Database.
     */
    public function getDefaultDatabase() {
        return $this->defaultDatabase;
    }

    /**
     * Sets the default application database.
     * @param string $identifier Database unique identifier.
     */
    public function setDefaultDatabase($identifier) {
        $this->defaultDatabase = $this->getDatabase($identifier);
    }

    /**
     * Gets the default email server.
     * @return E extends EmailServer Default EmailServer.
     */
    public function getDefaultEmailServer() {
        return $this->defaultEmailServer;
    }

    /**
     * Sets the default application email server.
     * @param string $identifier EmailServer unique identifier.
     */
    public function setDefaultEmailServer($identifier) {
        $this->defaultEmailServer = $this->getEmailServer($identifier);
    }
    
    /**
     * Gets the default theme.
     * @return Theme Default Theme.
     */
    public function getDefaultTheme() {
        return $this->defaultTheme;
    }

    /**
     * Sets the default application theme.
     * @param string $identifier Theme unique identifier.
     */
    public function setDefaultTheme($identifier) {
        $this->defaultTheme = $this->getTheme($identifier);
    }

}
