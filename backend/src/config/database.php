<?php
/**
 * Database Configuration
 * 
 * This file contains the database connection parameters.
 * Keep this file secure and don't commit it to version control with real credentials.
 */

return [
    'host' => 'localhost',
    'dbname' => 'test',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
