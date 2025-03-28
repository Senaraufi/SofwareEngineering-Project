<?php

namespace App\Models;

/**
 * Genre Model
 * 
 * Represents a music genre in the TalkTempo application
 */
class Genre extends BaseModel {
    private $genre_id;
    private $name;
    private $description;

    
    /**
     * Constructor
     * 
     * @param array $data Genre data from database
     */
    public function __construct(array $data = []) {
        $this->genre_id = $data['genre_id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? null;
        parent::__construct($data);
    }
    
    /**
     * Get genre ID
     * 
     * @return int|null Genre ID
     */
    public function getId(): ?int {
        return $this->genre_id;
    }
    
    /**
     * Get genre name
     * 
     * @return string Genre name
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Set genre name
     * 
     * @param string $name New genre name
     * @return Genre This Genre instance for method chaining
     */
    public function setName(string $name): Genre {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get genre description
     * 
     * @return string|null Genre description
     */
    public function getDescription(): ?string {
        return $this->description;
    }
    
    /**
     * Set genre description
     * 
     * @param string|null $description New genre description
     * @return Genre This Genre instance for method chaining
     */
    public function setDescription(?string $description): Genre {
        $this->description = $description;
        return $this;
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
     * Convert genre to array
     * 
     * @return array Genre data as array
     */
    public function toArray(): array {
        return [
            'genre_id' => $this->genre_id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at
        ];
    }
}
