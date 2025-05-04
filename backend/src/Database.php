<?php
/**
 * Database Class
 */

namespace App;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        // Load database configuration
        $config = require __DIR__ . '/config/database.php';
        
        try {
            // First try to connect to the database
            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
                $this->pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            } catch (PDOException $e) {
                // If database doesn't exist, try connecting without specifying a database
                if (strpos($e->getMessage(), "Unknown database") !== false) {
                    $dsn = "mysql:host={$config['host']}";
                    $this->pdo = new PDO($dsn, $config['username'], $config['password']);
                    
                    // Create the database
                    $this->pdo->exec("CREATE DATABASE IF NOT EXISTS {$config['dbname']}");
                    $this->pdo->exec("USE {$config['dbname']}");
                    
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
            
            // Set PDO attributes from config
            foreach ($config['options'] as $attribute => $value) {
                $this->pdo->setAttribute($attribute, $value);
            }
        } catch (PDOException $e) {
            // Log error instead of exposing details
            error_log("Database connection error: " . $e->getMessage());
            throw new \Exception("Database connection failed. See error log for details.");
        }
    }
    
    /**
     * Get the singleton instance of the Database class
     * 
     * Implementation based on the Singleton pattern from:
     * - PHP: The Right Way - Design Patterns
     * - URL: https://phptherightway.com/pages/Design-Patterns.html#singleton
     * 
     * @return Database The singleton instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    /**
     * Execute a SQL query with parameters
     * 
     * References:
     * - Error handling approach: PHP Manual - Exceptions
     *   URL: https://www.php.net/manual/en/language.exceptions.php
     *   Section: "Extending Exceptions"
     * 
     * - Prepared statements: PHP Manual - PDO::prepare
     *   URL: https://www.php.net/manual/en/pdo.prepare.php
     * 
     * @param string $sql SQL query with placeholders
     * @param array $params Parameters to bind to the query
     * @return \PDOStatement The statement object
     * @throws \Exception If the query fails
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Log the full error details for debugging
            error_log("Query failed: " . $e->getMessage() . " SQL: " . $sql);
            
            // Check if the error is related to a missing table
            if (strpos($e->getMessage(), "Table") !== false && strpos($e->getMessage(), "doesn't exist") !== false) {
                throw new \Exception("Database table not found. The application may need to be initialized.");
            }
            
            // Generic error message for other database issues
            throw new \Exception("Database query failed. See error log for details.");
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
            error_log("Insert failed: " . $e->getMessage());
            throw new \Exception("Database insert operation failed. See error log for details.");
        }
    }
    
    public function findOne($table, $conditions) {
        try {
            // Check if table exists first
            $checkTableQuery = "SHOW TABLES LIKE '$table'";
            $tableExists = $this->query($checkTableQuery)->rowCount() > 0;
            
            if (!$tableExists) {
                error_log("Table does not exist: $table");
                return null;
            }
            
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
        } catch (\Exception $e) {
            // Log the error but return null instead of throwing an exception
            error_log("findOne failed: " . $e->getMessage());
            return null;
        }
    }
}
