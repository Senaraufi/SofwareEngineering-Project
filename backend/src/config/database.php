<?php
/**
 * Database Configuration
 * 
 * This file contains the database connection parameters.
 * Keep this file secure and don't commit it with real credentials.
 */

return [
    'host' => 'localhost:3307', // the new port 
    'dbname' => 'talktempo',
    'username' => 'root',
    'password' => '',       // Updated this just in case MySQL has a password
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,// Set error mode to exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,// Set default fetch mode to associative array
        PDO::ATTR_EMULATE_PREPARES => false,// Disable prepared statements
    ]
];
