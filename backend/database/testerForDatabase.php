<?php

class DatabaseConnection {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            // MySQL connection settings
            $host = 'localhost';
            $dbname = 'talktempo';
            $username = 'root';
            $password = 'Abbeyvale7';
            
            // Create MySQL database connection using PDO
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->pdo = new PDO($dsn, $username, $password, $options);
            
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Singleton pattern to ensure only one database connection
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    // Test function to verify database connection and schema
    public function testConnection() {
        try {
            // Test query to get all genres
            $stmt = $this->pdo->query("SELECT * FROM Genres");
            $genres = $stmt->fetchAll();
            
            echo "Database connection successful!\n";
            echo "Found " . count($genres) . " genres in the database.\n";
            
            // Display first few genres
            echo "Sample genres: \n";
            $count = 0;
            foreach($genres as $genre) {
                if ($count < 5) {
                    echo "- " . $genre['name'] . "\n";
                    $count++;
                } else {
                    break;
                }
            }
            
            return true;
            
        } catch(PDOException $e) {
            echo "Test failed: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserializing of the instance
    public function __wakeup() {}
    
    // Clean up the connection when the object is destroyed
    public function __destruct() {
        if ($this->pdo) {
            $this->pdo = null;
        }
    }
}

// Usage example:
try {
    $db = DatabaseConnection::getInstance();
    $db->testConnection();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}