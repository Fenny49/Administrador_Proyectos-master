<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     * Esta es la ÚNICA configuración que usaremos para nuestra aplicación.
     *
     * @var array<string, mixed>
     */
    public array $default = [
        'DSN'          => '',
        'hostname'     => 'DESKTOP-I95M29J\SQLDEVE2022',
        'username'     => 'sa',
        'password'     => '123456',
        'database'     => 'pruebas',
        'DBDriver'     => 'SQLSRV', 
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,    
        'charset'      => 'utf8',  
        'DBCollat'     => '',     
        'swapPre'      => '',
        'encrypt'      => false,   
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 1433,
    ];

    /**
     * This database connection is used when running PHPUnit database tests.
     * No lo modificamos, es para pruebas automatizadas.
     *
     * @var array<string, mixed>
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => 'localhost',
        'username'    => 'sa',
        'password'    => 'root',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3', 
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'strictOn'    => false,
        'failover'    => [],
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];

    public function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}