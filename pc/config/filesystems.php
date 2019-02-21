<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        '10' => [
            'driver' => 'local',
            'root' =>'/',
        ],

        'incidencias' => [
            'driver' => 'local',
            'root' => storage_path('incidencias'),
        ],
        'banamex' => [
            'driver' => 'local',
            'root' => public_path('assets/img/Banamex'),
        'visibility' => 'public',
        ],
        // 'banamex' => [
        //     'driver' => 'local',
        //     'root' => storage_path('Banamex'),
        // 'visibility' => 'public',
        // ],


        'public' => [
            'driver' => 'local',
            //'root' => public_path('inbursa'),
			//'root' => public_path().'inbursa',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],
        'ftp' => [
        'driver'   => 'ftp',
        'host'     => 'peopleconnect.com.mx',
        'username' => 'bancomer',
        'password' => 'c$u~vrZ=[e6i',
        'port'     => 21,

        // Optional FTP Settings...
        // 'port'     => 21,
        // 'root'     => '',
        // 'passive'  => true,
        // 'ssl'      => true,
        // 'timeout'  => 30,
    ],
      'ftpInbursa' => [
        'driver'   => 'ftp',
        'host'     => 'peopleconnect.com.mx',
        'username' => 'inbursa@peopleconnect.com.mx',
        'password' => 'PeopleC0nnectin',
        'port'     => 21,
      ],

    ],

];
