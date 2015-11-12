<?php

require_once __dir__ . '/config/config.inc.php';

/**
 * Site's configuration instance.
 */
$config = new Config();

/**
 * Add databases here.
 */
$config->addDatabase(
    '<database alias>',                         //Database alias.
    new MySQLDatabase(                          //Database type.
        new DatabaseConfig(
            '<host address>',                   //Database host address.
            MySQLDatabase::DEFAULT_PORT,        //Database connection port.
            '<database name>',                  //Database name.
            '<database user>',                  //Database user.
            '<database password>'               //Database password.
        )
    )
);

/**
 * Add email servers here.
 */
$config->addEmailServer(
    '<email server alias>',                     //Email server alias.
    new SMTPEmailServer(                        //Email server type.
        new EmailServerConfig(
            array(                              //Email server hosts
                '<email server addresses>'
            ),
             SMTPEmailServer::DEFAULT_PORT,     //Email server connection port.
            '<email server user>',              //Email server user.
            '<email server password>'           //Email server password.
        )
    )
);


/*$config->addOAuthClient(
    '<oauth client alias>',                     //OAuth client alias.
    new OAuthClient(                            //Custom OAuthClient implementation
        new OAuthClientConfig(
            new OAuthClientKeys(
                '<consumer key>',               //OAuth client consumer key.
                '<consumer secret>'             //OAuth client consumer secret.
            ),
            new OAuthClientUrls(
                '<request token url>',          //Request token URL.
                '<authorisation url>',          //Authorisation URL.
                '<access token url>',           //Access token URL.
                '<access token refresh url>',   //Access token refresh URL.
                '<authentication url>',         //Authentication URL.
                '<callback url>'                //Callback URL.
            )
        )
    )
);*/

/**
 * Add themes here
 */
$config->addTheme(
    '<theme alias>',
    new Theme(
        new ThemeConfig(
            __DIR__ . '/path/to/theme'
        )
    )
);

/**
 * Set defaults here.
 */
$config->setDefaultDatabase('<database alias>');
$config->setDefaultEmailServer('<email server alias>');
$config->setDefaultOAuthClient('<oauth client alias>');
$config->setDefaultTheme('<theme alias>');