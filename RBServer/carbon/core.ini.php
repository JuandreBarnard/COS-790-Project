<?php

require_once __dir__ . '/config/config.inc.php';

$config = new Config();

$config->addDatabase(
    'restaurant_buddy',                    //Database alias.
    new MySQLDatabase(                      //Database type.
        new DatabaseConfig(
            '127.0.0.1',                    //Database host address.
            MySQLDatabase::DEFAULT_PORT,    //Database connection port.
            'restaurant_buddy',                     //Database name.
            'root',                         //Database user.
            ''                              //Database password.
        )
    )
);

$config->addTheme(
    'restaurantbuddy',
    new Theme(
        new ThemeConfig(
            __DIR__ . '/../themes/restaurantbuddy'
        )
    )
);

/**
 * Set defaults here.
 */
$config->setDefaultDatabase('restaurant_buddy');
$config->setDefaultTheme('restaurantbuddy');