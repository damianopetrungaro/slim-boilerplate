<?php

use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

return [
    "paths" => [
        "migrations" => "db/migrations",
        "seeds" => "db/seeds"
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "dev",
        "dev" => [
            "adapter" => "mysql",
            "host" => getenv('DB_HOST') ?: 'localhost',
            "name" => getenv('DB_NAME') ?: 'db',
            "user" => getenv('DB_USER') ?: 'root',
            "pass" => getenv('DB_PASSWORD') ?: 'root',
            "port" => getenv('DB_PORT') ?: '3306'
        ],
        "prod" => [
            "adapter" => "mysql",
            "host" => getenv('DB_HOST') ?: 'localhost',
            "name" => getenv('DB_NAME') ?: 'db',
            "user" => getenv('DB_USER') ?: 'root',
            "pass" => getenv('DB_PASSWORD') ?: 'root',
            "port" => getenv('DB_PORT') ?: '3306'
        ],
        "test" => [
            "adapter" => "mysql",
            "host" => getenv('DB_HOST') ?: 'localhost',
            "name" => getenv('DB_NAME') ?: 'db',
            "user" => getenv('DB_USER') ?: 'root',
            "pass" => getenv('DB_PASSWORD') ?: 'root',
            "port" => getenv('DB_PORT') ?: '3306'
        ]
    ]
];