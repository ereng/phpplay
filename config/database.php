<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlml4afrika' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_ML4AFRIKA', '127.0.0.1'),
            'port' => env('DB_PORT_ML4AFRIKA', '3306'),
            'database' => env('DB_DATABASE_ML4AFRIKA', 'forge'),
            'username' => env('DB_USERNAME_ML4AFRIKA', 'forge'),
            'password' => env('DB_PASSWORD_ML4AFRIKA', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlmedbook' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_MEDBOOK', '127.0.0.1'),
            'port' => env('DB_PORT_MEDBOOK', '3306'),
            'database' => env('DB_DATABASE_MEDBOOK', 'forge'),
            'username' => env('DB_USERNAME_MEDBOOK', 'forge'),
            'password' => env('DB_PASSWORD_MEDBOOK', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlschmgtsys' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_SCHMGTSYS', '127.0.0.1'),
            'port' => env('DB_PORT_SCHMGTSYS', '3306'),
            'database' => env('DB_DATABASE_SCHMGTSYS', 'forge'),
            'username' => env('DB_USERNAME_SCHMGTSYS', 'forge'),
            'password' => env('DB_PASSWORD_SCHMGTSYS', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlchaplaincy' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_CHAPLAINCY', '127.0.0.1'),
            'port' => env('DB_PORT_CHAPLAINCY', '3306'),
            'database' => env('DB_DATABASE_CHAPLAINCY', 'forge'),
            'username' => env('DB_USERNAME_CHAPLAINCY', 'forge'),
            'password' => env('DB_PASSWORD_CHAPLAINCY', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlblis' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_BLIS', '127.0.0.1'),
            'port' => env('DB_PORT_BLIS', '3306'),
            'database' => env('DB_DATABASE_BLIS', 'forge'),
            'username' => env('DB_USERNAME_BLIS', 'forge'),
            'password' => env('DB_PASSWORD_BLIS', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlriverside' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_RIVERSIDE', '127.0.0.1'),
            'port' => env('DB_PORT_RIVERSIDE', '3306'),
            'database' => env('DB_DATABASE_RIVERSIDE', 'forge'),
            'username' => env('DB_USERNAME_RIVERSIDE', 'forge'),
            'password' => env('DB_PASSWORD_RIVERSIDE', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlhis' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_HIS', '127.0.0.1'),
            'port' => env('DB_PORT_HIS', '3306'),
            'database' => env('DB_DATABASE_HIS', 'forge'),
            'username' => env('DB_USERNAME_HIS', 'forge'),
            'password' => env('DB_PASSWORD_HIS', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysqlaho' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_AHO', '127.0.0.1'),
            'port' => env('DB_PORT_AHO', '3306'),
            'database' => env('DB_DATABASE_AHO', 'forge'),
            'username' => env('DB_USERNAME_AHO', 'forge'),
            'password' => env('DB_PASSWORD_AHO', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        'testing' => [
            'driver'    => 'mysql',
            'host'      => env('DB_TEST_HOST', 'localhost'),
            'database'  => env('DB_TEST_DATABASE', 'homestead_test'),
            'username'  => env('DB_TEST_USERNAME', 'homestead'),
            'password'  => env('DB_TEST_PASSWORD', 'secret'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
