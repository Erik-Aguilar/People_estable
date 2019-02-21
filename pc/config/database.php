<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

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
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'queue_log_asterisk_inbursa' => [
          'driver' => 'sqlsrv',
          'host' => 'peopleconnect-asterisk-db.database.windows.net',
          'database' => 'reportes_marcacion',
          'username' => 'peopleconnect',
          'password' => 'S1st3m4sr3l04D',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ]
        ],

        'mysql_rules' => [
          // 'driver' => 'sqlsrv',
          // 'host' => 'peopleconnect-asterisk-db.database.windows.net',
          // 'database' => 'reportes_marcacion',
          // 'username' => 'peopleconnect',
          // 'password' => 'S1st3m4sr3l04D',
            'driver' => 'mysql',
            'host' => '13.85.24.249',
            'port' => '3306',
            'database' => 'reportes_marcacion',
            'username' => 'root',
            'password' => 'S1st3m4sr3l04D',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ]
        ],
        'mysql_ethics' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_rules', '52.183.36.191'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE_ethics', 'forge'),
            'username' => env('DB_USERNAME_rules', 'forge'),
            'password' => env('DB_PASSWORD_rules', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ]
        ],

        'mysql_rules2' => [
            'driver' => 'mysql',
            'host' => '13.85.24.249',
			#'host' => '52.175.249.95',
            'port' => env('DB_PORT', '3306'),
            'database' => 'bases',
            'username' => 'root',
            'password' => 'S1st3m4sr3l04D',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ]
        ],

        'mysql14' => [
            'driver' => 'mysql',
            'host' => env('DB14_HOST', 'localhost'),
            'port' => env('DB14_PORT', '3306'),
            'database' => env('DB14_DATABASE', 'forge'),
            'username' => env('DB14_USERNAME', 'forge'),
            'password' => env('DB14_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],

        'mysql_per' => [
            'driver' => 'mysql',
            'host' => env('DB14_HOST', 'localhost'),
            'port' => env('DB14_PORT', '3306'),
            'database' => env('DB_Esq_DATABASE', 'personal'),
            'username' => env('DB14_USERNAME', 'forge'),
            'password' => env('DB14_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlbanamex' => [
            'driver' => 'mysql',
            'host' => env('DB_BAnamex_HOST', 'localhost'),
            'port' => env('DB_BAnamex_PORT', '3306'),
            'database' => env('DB_BAnamex_DATABASE', 'forge'),
            'username' => env('DB_BAnamex_USERNAME', 'forge'),
            'password' => env('DB_BAnamex_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlbancomer' => [
            'driver' => 'mysql',
            'host' => env('DB_Bancomer_HOST', 'localhost'),
            'port' => env('DB_Bancomer_PORT', '3306'),
            'database' => env('DB_Bancomer_DATABASE', 'forge'),
            'username' => env('DB_Bancomer_USERNAME', 'forge'),
            'password' => env('DB_Bancomer_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlbancomer2' => [
            'driver' => 'mysql',
            'host' => env('DB_Bancomer2_HOST', 'localhost'),
            'port' => env('DB_Bancomer2_PORT', '3306'),
            'database' => env('DB_Bancomer2_DATABASE', 'forge'),
            'username' => env('DB_Bancomer2_USERNAME', 'forge'),
            'password' => env('DB_Bancomer2_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlbancomer3' => [
            'driver' => 'mysql',
            'host' => env('DB_Bancomer3_HOST', 'localhost'),
            'port' => env('DB_Bancomer3_PORT', '3306'),
            'database' => env('DB_Bancomer3_DATABASE', 'forge'),
            'username' => env('DB_Bancomer3_USERNAME', 'forge'),
            'password' => env('DB_Bancomer3_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],

        'mysqlpersonal' => [
            'driver' => 'mysql',
            'host' => env('DB_Personal_HOST', 'localhost'),
            'port' => env('DB_Personal_PORT', '3306'),
            'database' => env('DB_Personal_DATABASE', 'forge'),
            'username' => env('DB_Personal_USERNAME', 'forge'),
            'password' => env('DB_Personal_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],

        'mysqlmapfre' => [
            'driver' => 'mysql',
            'host' => env('DB_Mapfre_HOST', 'localhost'),
            'port' => env('DB_Mapfre_PORT', '3306'),
            'database' => env('DB_Mapfre_DATABASE', 'forge'),
            'username' => env('DB_Mapfre_USERNAME', 'forge'),
            'password' => env('DB_Mapfre_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlmapfre2' => [
            'driver' => 'mysql',
            'host' => env('DB_Mapfre_HOST', 'localhost'),
            'port' => env('DB_Mapfre_PORT', '3306'),
            'database' => env('DB_Mapfre_DATABASE2', 'forge'),
            'username' => env('DB_Mapfre_USERNAME', 'forge'),
            'password' => env('DB_Mapfre_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlPospago' => [
            'driver' => 'mysql',
            'host' => env('DB_Pospago_HOST', 'localhost'),
            'port' => env('DB_Pospago_PORT', '3306'),
            'database' => env('DB_Pospago_DATABASE', 'forge'),
            'username' => env('DB_Pospago_USERNAME', 'forge'),
            'password' => env('DB_Pospago_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlSistemas' => [
            'driver' => 'mysql',
            #'host' => env('DB_Sistemas_HOST', 'localhost'),
            'host' => env('DB_Sistemas_HOST', 'localhost'),
            'port' => env('DB_Sistemas_PORT', '3306'),
            'database' => env('DB_Sistemas_DATABASE', 'forge'),
            'username' => env('DB_Sistemas_USERNAME', 'forge'),
            'password' => env('DB_Sistemas_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlauri' => [
            'driver' => 'mysql',
            'host' => env('DB_Auri_HOST', 'localhost'),
            'port' => env('DB_Auri_PORT', '3306'),
            'database' => env('DB_Auri_DATABASE', 'forge'),
            'username' => env('DB_Auri_USERNAME', 'forge'),
            'password' => env('DB_Auri_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlconaliteg' => [
            'driver' => 'mysql',
            'host' => env('DB_Conaliteg_HOST', 'localhost'),
            'port' => env('DB_Conaliteg_PORT', '3306'),
            'database' => env('DB_Conaliteg_DATABASE', 'forge'),
            'username' => env('DB_Conaliteg_USERNAME', 'forge'),
            'password' => env('DB_Conaliteg_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlconalitegpbx' => [
            'driver' => 'mysql',
            'host' => env('DB_PbxConaliteg_HOST', 'localhost'),
            'port' => env('DB_PbxConaliteg_PORT', '3306'),
            'database' => env('DB_PbxConaliteg_DATABASE', 'forge'),
            'username' => env('DB_PbxConaliteg_USERNAME', 'forge'),
            'password' => env('DB_PbxConaliteg_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlbmxpbx' => [
            'driver' => 'mysql',
            'host' => env('DB_Bmx_HOST', 'localhost'),
            'port' => env('DB_Bmx_PORT', '3306'),
            'database' => env('DB_Bmx_DATABASE', 'forge'),
            'username' => env('DB_Bmx_USERNAME', 'forge'),
            'password' => env('DB_Bmx_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
        'mysqlpbxinb' => [
            'driver' => 'mysql',
            'host' => env('DB_PbxInb_HOST', 'localhost'),
            'port' => env('DB_PbxInb_PORT', '3306'),
            'database' => env('DB_PbxInb_DATABASE', 'forge'),
            'username' => env('DB_PbxInb_USERNAME', 'forge'),
            'password' => env('DB_PbxInb_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],

        'mysqlInbVidatel' => [
            'driver' => 'mysql',
            'host' => env('DB_Inbursa_Vidatel_HOST', 'localhost'),
            'port' => env('DB_Inbursa_Vidatel_PORT', '3306'),
            'database' => env('DB_Inbursa_Vidatel_DATABASE', 'forge'),
            'username' => env('DB_Inbursa_Vidatel_USERNAME', 'forge'),
            'password' => env('DB_Inbursa_Vidatel_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],
		
		'mysqlInbSoluciones' => [
            'driver' => 'mysql',
            'host' => 'peco.mysql.database.azure.com',
            'port' => env('DB_Inbursa_Soluciones_PORT', '3306'),
            'database' => 'inbursa_soluciones',
            'username' => 'adan@peco',
            'password' => 'S1st3m4sr3l04D',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1
            ]
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ],
		
		'tmdatos' => [
            'driver' => 'mysql',
            'host' => '52.183.36.191',
            'port' => '3306',
            'database' => 'reportes_marcacion',
            'username' => 'root',
            'password' => 'S1st3m4sr3l04D',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
            'options'   => [
                \PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ]
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

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
