<?php

$host = 'localhost';
$username = 'root';
$password = 'Abbeyvale7';

try {
    // Create connection to MySQL server using PDO
    $pdo = new PDO("mysql:host=$host", $username, $password);
    
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop existing database if it exists
    $pdo->exec("DROP DATABASE IF EXISTS talktempo");
    echo "Dropped existing database if it existed\n";
    
    // Create database
    $sql = "CREATE DATABASE talktempo";
    $pdo->exec($sql);
    echo "Database created successfully\n";
    
    // Select the database
    $pdo->exec("USE talktempo");
    
    // Read and execute the schema
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    
    // Split the schema into individual statements
    $statements = array_filter(explode(';', $schema), 'trim');
    
    // Execute each statement
    foreach ($statements as $statement) {
        if (trim($statement) != '') {
            try {
                $pdo->exec($statement);
            } catch (PDOException $e) {
                die("Error executing statement: " . $e->getMessage() . "\nStatement: " . $statement . "\n");
            }
        }
    }
    
    echo "Schema imported successfully!\n";
    echo "Database is ready to use!\n";
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}
