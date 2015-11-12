<?php

require_once __DIR__ . '/Database.class.php';
require_once __DIR__ . '/PDOConnection.class.php';

/**
 * An implementation of Database that uses the SQLSRV/DBLib driver.
 */
class SQLSrvUnixDatabase extends Database {

    /**
     * Default port.
     */
    const DEFAULT_PORT = 1433;
    
    /**
     * SQLSrvUnix constructor.
     * @param DatabaseConfig $databaseConfig Database configuration.
     */
    public function __construct(DatabaseConfig $databaseConfig) {
        parent::__construct($databaseConfig);
    }

    /**
     * Generates a DSN (Data Source Name) string from the database configuration.
     * @return string
     */
    protected function generateDSN() {
        $host = $this->databaseConfig->getHost();
        $port = $this->databaseConfig->getPort();
        $database = $this->databaseConfig->getDatabase();
        $parameters = $this->databaseConfig->getParamerers();

        $dsn = 'dblib';
        $dsn .= ':';
        $dsn .= 'host=' . $host . ';';
        $dsn .= ($port) ? 'port=' . $port . ';' : ';';
        $dsn .= ($database) ? 'dbname=' . $database . ';' : ';';
        
        if($parameters !== NULL){
            foreach($parameters AS $parametersKey => $parameterValue){
                $dsn .= $parametersKey . '=' . $parameterValue;
            }
        }
        
        return $dsn;
    }

    /**
     * Opens up a database connection.
     * @return PDOConnection Database PDO connection.
     */
    public function open() {
        try{
            $dsn = $this->generateDSN();
            $user = $this->databaseConfig->getUser();
            $password = $this->databaseConfig->getPassword();
            $debug = $this->databaseConfig->getDebug();
            return new PDOConnection($dsn, $user, $password, $debug);
        }
        catch (PDOException $ex){
            ?>
            <link type='text/css' rel='stylesheet' href='//cdn.consulta.co.za/bootstrap-consulta/latest/css/bootstrap.min.css' />
            <div class='container text-center'>
                <div  style='position: absolute; height: 300px; top: 50%; margin-top: -150px; width: 500px; left: 50%; margin-left: -250px;'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Oops! PDOException was caught.
                        </div>
                        <div class='panel-body'>
                            <?php echo $ex->getMessage(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            die();
        }
    }

}
