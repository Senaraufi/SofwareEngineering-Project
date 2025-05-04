<?php
/**
 * Database Configuration
 * 
 * This file contains the database connection parameters.
 * Keep this file secure and don't commit it with real credentials.
 */

return [
    'host' => 'localhost', // Reverting to default
    'dbname' => 'talktempo',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,// Set error mode to exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,// Set default fetch mode to associative array
        PDO::ATTR_EMULATE_PREPARES => false,// Disable prepared statements
    ]
];
