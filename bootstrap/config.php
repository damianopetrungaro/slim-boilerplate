<?php

$config = [
    'db' => [
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST') ?: 'localhost',
        'database'  => getenv('DB_NAME') ?: 'db',
        'username'  => getenv('DB_USER') ?: 'root',
        'password'  => getenv('DB_PASSWORD') ?: 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'unix_socket'   => '/Applications/MAMP/tmp/mysql/mysql.sock',
    ]
];
