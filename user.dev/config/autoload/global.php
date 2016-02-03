<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    // Set up the service manager
    'service_manager' => array(
        // Initiate the connection at the start of the
        // application
        'factories' => array(
            // Use the service factory to start up our db
            // adapter
            'Zend\Db\Adapter\Adapter' => Zend\Db\Adapter\AdapterServiceFactory::class,
        ),
        'invokables' => [

        ],
        'initializers' => array(
            'User\Service\Initializer\MapperInitializer',
        ),
        'aliases' => array(
            // Use this db alias in the controllers to get the
            // initialized connection. The value of the db key refers to
            // the factories key with the same name.
            'db' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
    'db' => array(
        // We want to use the PDO to connect to the database
        'driver' => 'pdo',
        // DSN, or data source name is a connection url that
        // shows the driver (in this case the PDO) where to
        // connect to. The first bit is the driver to use,
        // then follows the database name and the host. More
        // information on the dsn options can be found here:
        // http://php.net/manual/en/pdo.construct.php
        'dsn' => 'pgsql:dbname=postgres;host=localhost',
        // Username and password (or at the very least the
        // password) should NOT be in the global.php. This
        // file usually will be committed to a version
        // control, which means your password will be
        // publicly available.
        'username' => '',
        'password' => '',
    ),
);
