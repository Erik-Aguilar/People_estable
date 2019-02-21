<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Remote Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default connection that will be used for SSH
    | operations. This name should correspond to a connection name below
    | in the server list. Each connection will be manually accessible.
    |
    */

    'default' => 'production',

    /*
    |--------------------------------------------------------------------------
    | Remote Server Connections
    |--------------------------------------------------------------------------
    |
    | These are the servers that will be accessible via the SSH task runner
    | facilities of Laravel. This feature radically simplifies executing
    | tasks on your servers, such as deploying out these applications.
    |
    */

    'connections' => [
      'production' => [
          'host'      => '201.155.38.192',
          'username'  => 'salescom_cc',
          'password'  => 'Jy3L_QPx',
          #'key'       => '',
          #'keytext'   => '',
          #'keyphrase' => '',
          #'agent'     => '',
          #'port'     => 22,
          #'timeout'   => 200,
      ],
      'bancomer' => [
          'host'      => 'peopleconnect.com.mx',
          'username'  => 'bancomer',
          'password'  => 'c$u~vrZ=[e6i',
          #'key'       => '',
          #'keytext'   => '',
          #'keyphrase' => '',
          #'agent'     => '',
          'port'     => 21,
          'timeout'   => 20000,
      ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Remote Server Groups
    |--------------------------------------------------------------------------
    |
    | Here you may list connections under a single group name, which allows
    | you to easily access all of the servers at once using a short name
    | that is extremely easy to remember, such as "web" or "database".
    |
    */

    'groups' => [
        'web' => ['production'],
    ],

];
