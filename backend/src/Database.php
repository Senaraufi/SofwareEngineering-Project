<?php

namespace App;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        $host = 'localhost';
        $dbname = 'talktempo';
        $username = 'root';
        $password = ''; // Empty password for local development
        
        try {
            // First try to connect to the database
            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            } catch (PDOException $e) {
                // If database doesn't exist, try connecting without specifying a database
                if (strpos($e->getMessage(), "Unknown database") !== false) {
                    $this->pdo = new PDO("mysql:host=$host", $username, $password);
                    // Create the database
                    $this->pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
                    $this->pdo->exec("USE $dbname");
                    
                    // Import schema
                    $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
                    $statements = array_filter(explode(';', $schema), 'trim');
                    
                    foreach ($statements as $statement) {
                        if (trim($statement) != '') {
                            try {
                                $this->pdo->exec($statement);
                            } catch (PDOException $e) {
                                // Continue even if some statements fail
                                error_log("Error executing SQL statement: " . $e->getMessage());
                            }
                        }
                    }
                } else {
                    throw $e; // Re-throw if it's not an 'unknown database' error
                }
            }
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_values($data));
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Insert failed: " . $e->getMessage());
        }
    }
    
    public function findOne($table, $conditions) {
        $where = [];
        $params = [];
        
        foreach ($conditions as $key => $value) {
            $where[] = "$key = ?";
            $params[] = $value;
        }
        
        $whereClause = implode(' AND ', $where);
        $sql = "SELECT * FROM $table WHERE $whereClause LIMIT 1";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    // The getConnection method is already defined above (line 62)
}
