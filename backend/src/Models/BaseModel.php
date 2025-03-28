<?php

namespace App\Models;

/**
 * BaseModel
 * 
 * Base class for all models in the TalkTempo application
 */
abstract class BaseModel {
    protected $created_at;
    protected $updated_at;
    
    /**
     * Constructor
     * 
     * @param array $data Model data from database
     */
    public function __construct(array $data = []) {
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
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
