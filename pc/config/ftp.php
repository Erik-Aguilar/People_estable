<?php
return array(

    /*
	|--------------------------------------------------------------------------
	| Default FTP Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the FTP connections below you wish
	| to use as your default connection for all ftp work.
	|
	*/

    'default' => 'connection1',

    /*
    |--------------------------------------------------------------------------
    | FTP Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the FTP connections setup for your application.
    |
    */

    'connections' => array(

        'production' => array(
            'host'   => '201.155.38.192',
            'port'  => 22,
            'username' => 'salescom_cc',
            'password'   => 'Jy3L_QPx',
            'passive'   => false,
        ),
        
        // 'connection1' => array(
        //     'host'   => '',
        //     'port'  => 21,
        //     'username' => '',
        //     'password'   => '',
        //     'passive'   => false,
        // ),

    ),
);
