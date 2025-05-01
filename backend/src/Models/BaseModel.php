<?php

namespace App\Models;

use App\Database;

/**
 * BaseModel
 * 
 * Base class for all models in the TalkTempo application
 * Provides common CRUD operations and database connectivity
 * 
 * References:
 * - Active Record Pattern: Martin Fowler - Patterns of Enterprise Application Architecture
 *   URL: https://martinfowler.com/eaaCatalog/activeRecord.html
 * 
 * - Laravel's Eloquent ORM (inspiration for method structure)
 *   URL: https://laravel.com/docs/8.x/eloquent
 *   Sections: "Retrieving Models" and "Inserts"
 * 
 * - PHP & MySQL: Novice to Ninja (6th Edition)
 *   Author: Tom Butler & Kevin Yank
 *   Chapter: "Creating a Data Access Layer"
 */
abstract class BaseModel {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $created_at;
    protected $updated_at;
    
    /**
     * Constructor
     * 
     * @param array $data Model data from database
     */
    public function __construct(array $data = []) {
        $this->db = Database::getInstance();
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }
    
    /**
     * Find all records
     * 
     * Implementation inspired by:
     * - Laravel's Eloquent ORM: Model::all() method
     *   URL: https://laravel.com/docs/8.x/eloquent#retrieving-models
     * 
     * @return array All records
     */
    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Find record by ID
     * 
     * @param int $id Record ID
     * @return array|false Record data or false if not found
     */
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql, [$id])->fetch();
    }
    
    /**
     * Find records by field value
     * 
     * @param string $field Field name
     * @param mixed $value Field value
     * @return array Records matching criteria
     */
    public function findBy($field, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = ?";
        return $this->db->query($sql, [$value])->fetchAll();
    }
    
    /**
     * Create a new record
     * 
     * Implementation inspired by:
     * - Laravel's Eloquent ORM: Model::create() method
     *   URL: https://laravel.com/docs/8.x/eloquent#inserts
     * 
     * - Timestamp handling approach from:
     *   PHP & MySQL: Novice to Ninja (6th Edition)
     *   Author: Tom Butler & Kevin Yank
     *   Chapter: "Creating a Data Access Layer"
     * 
     * @param array $data Record data
     * @return int|false New record ID or false on failure
     */
    public function create(array $data) {
        // Add timestamps if table supports them
        if (!isset($data['created_at']) && $this->hasTimestamps()) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['updated_at']) && $this->hasTimestamps()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Update a record
     * 
     * @param int $id Record ID
     * @param array $data Updated data
     * @return bool Success status
     */
    public function update($id, array $data) {
        // Add updated timestamp if table supports it
        if (!isset($data['updated_at']) && $this->hasTimestamps()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $setClauses = [];
        $params = [];
        
        foreach ($data as $key => $value) {
            $setClauses[] = "{$key} = ?";
            $params[] = $value;
        }
        
        $params[] = $id; // Add ID for WHERE clause
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setClauses) . " WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->query($sql, $params);
        
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Delete a record
     * 
     * @param int $id Record ID
     * @return bool Success status
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->query($sql, [$id]);
        
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Check if table has timestamp columns
     * 
     * @return bool True if table has timestamp columns
     */
    protected function hasTimestamps() {
        return true; // Override in child classes if needed
    }
    
    /**
     * Get created at timestamp
     * 
     * @return string|null Created at timestamp
     */
    public function getCreatedAt(): ?string {
        return $this->created_at;
    }
    
    /**
     * Get updated at timestamp
     * 
     * @return string|null Updated at timestamp
     */
    public function getUpdatedAt(): ?string {
        return $this->updated_at;
    }
    
    /**
     * Convert model to array
     * 
     * @return array Model data as array
     */
    abstract public function toArray(): array;
}
