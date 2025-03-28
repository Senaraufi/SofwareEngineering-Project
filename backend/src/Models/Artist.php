<?php

namespace App\Models;

/**
 * Artist Model
 * 
 * Represents a music artist in the TalkTempo application
 */
class Artist extends Genre {
    private $artist_id;
    private $name;
    private $description;
    private $image_url;

    private $updated_by;
    private $genres = [];
    
    /**
     * Constructor
     * 
     * @param array $data Artist data from database
     */
    public function __construct(array $data = []) {
        $this->artist_id = $data['artist_id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? null;
        $this->image_url = $data['image_url'] ?? null;
        parent::__construct($data);
        $this->updated_by = $data['updated_by'] ?? null;
    }
    
    /**
     * Get artist ID
     * 
     * @return int|null Artist ID
     */
    public function getId(): ?int {
        return $this->artist_id;
    }
    
    /**
     * Get artist name
     * 
     * @return string Artist name
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Set artist name
     * 
     * @param string $name New artist name
     * @return Artist This Artist instance for method chaining
     */
    public function setName(string $name): Artist {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get artist description
     * 
     * @return string|null Artist description
     */
    public function getDescription(): ?string {
        return $this->description;
    }
    
    /**
     * Set artist description
     * 
     * @param string|null $description New artist description
     * @return Artist This Artist instance for method chaining
     */
    public function setDescription(?string $description): Artist {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Get artist image URL
     * 
     * @return string|null Artist image URL
     */
    public function getImageUrl(): ?string {
        return $this->image_url;
    }
    
    /**
     * Set artist image URL
     * 
     * @param string|null $image_url New artist image URL
     * @return Artist This Artist instance for method chaining
     */
    public function setImageUrl(?string $image_url): Artist {
        $this->image_url = $image_url;
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
     * Get updated at timestamp
     * 
     * @return string|null Updated at timestamp
     */
    public function getUpdatedAt(): ?string {
        return $this->updated_at;
    }
    
    /**
     * Get updated by user ID
     * 
     * @return int|null Updated by user ID
     */
    public function getUpdatedBy(): ?int {
        return $this->updated_by;
    }
    
    /**
     * Set updated by user ID
     * 
     * @param int|null $user_id User ID who updated this artist
     * @return Artist This Artist instance for method chaining
     */
    public function setUpdatedBy(?int $user_id): Artist {
        $this->updated_by = $user_id;
        return $this;
    }
    
    /**
     * Get artist genres
     * 
     * @return array Array of Genre objects
     */
    public function getGenres(): array {
        return $this->genres;
    }
    
    /**
     * Set artist genres
     * 
     * @param array $genres Array of Genre objects
     * @return Artist This Artist instance for method chaining
     */
    public function setGenres(array $genres): Artist {
        $this->genres = $genres;
        return $this;
    }
    
    /**
     * Add a genre to this artist
     * 
     * @param Genre $genre Genre to add
     * @return Artist This Artist instance for method chaining
     */
    public function addGenre(Genre $genre): Artist {
        $this->genres[] = $genre;
        return $this;
    }
    
    /**
     * Convert artist to array
     * 
     * @param bool $include_genres Whether to include genres in the array
     * @return array Artist data as array
     */
    public function toArray(bool $include_genres = false): array {
        $data = [
            'artist_id' => $this->artist_id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by
        ];
        
        if ($include_genres) {
            $data['genres'] = array_map(function($genre) {
                return $genre->toArray();
            }, $this->genres);
        }
        
        return $data;
    }
}
