<?php

namespace App\Models;

/**
 * Album Model
 * 
 * Represents a music album in the TalkTempo application
 */
class Album {
    private $album_id;
    private $artist_id;
    private $title;
    private $release_date;
    private $description;
    private $image_url;
    private $created_at;
    private $updated_at;
    private $updated_by;
    private $artist;
    private $genres = [];
    
    /**
     * Constructor
     * 
     * @param array $data Album data from database
     */
    public function __construct(array $data = []) {
        $this->album_id = $data['album_id'] ?? null;
        $this->artist_id = $data['artist_id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->release_date = $data['release_date'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->image_url = $data['image_url'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->updated_by = $data['updated_by'] ?? null;
    }
    
    /**
     * Get album ID
     * 
     * @return int|null Album ID
     */
    public function getId(): ?int {
        return $this->album_id;
    }
    
    /**
     * Get artist ID
     * 
     * @return int|null Artist ID
     */
    public function getArtistId(): ?int {
        return $this->artist_id;
    }
    
    /**
     * Set artist ID
     * 
     * @param int $artist_id New artist ID
     * @return Album This Album instance for method chaining
     */
    public function setArtistId(int $artist_id): Album {
        $this->artist_id = $artist_id;
        return $this;
    }
    
    /**
     * Get album title
     * 
     * @return string Album title
     */
    public function getTitle(): string {
        return $this->title;
    }
    
    /**
     * Set album title
     * 
     * @param string $title New album title
     * @return Album This Album instance for method chaining
     */
    public function setTitle(string $title): Album {
        $this->title = $title;
        return $this;
    }
    
    /**
     * Get release date
     * 
     * @return string|null Release date
     */
    public function getReleaseDate(): ?string {
        return $this->release_date;
    }
    
    /**
     * Set release date
     * 
     * @param string|null $release_date New release date (Y-m-d format)
     * @return Album This Album instance for method chaining
     */
    public function setReleaseDate(?string $release_date): Album {
        $this->release_date = $release_date;
        return $this;
    }
    
    /**
     * Get album description
     * 
     * @return string|null Album description
     */
    public function getDescription(): ?string {
        return $this->description;
    }
    
    /**
     * Set album description
     * 
     * @param string|null $description New album description
     * @return Album This Album instance for method chaining
     */
    public function setDescription(?string $description): Album {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Get album image URL
     * 
     * @return string|null Album image URL
     */
    public function getImageUrl(): ?string {
        return $this->image_url;
    }
    
    /**
     * Set album image URL
     * 
     * @param string|null $image_url New album image URL
     * @return Album This Album instance for method chaining
     */
    public function setImageUrl(?string $image_url): Album {
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
     * @param int|null $user_id User ID who updated this album
     * @return Album This Album instance for method chaining
     */
    public function setUpdatedBy(?int $user_id): Album {
        $this->updated_by = $user_id;
        return $this;
    }
    
    /**
     * Get artist object
     * 
     * @return Artist|null Artist object
     */
    public function getArtist(): ?Artist {
        return $this->artist;
    }
    
    /**
     * Set artist object
     * 
     * @param Artist|null $artist Artist object
     * @return Album This Album instance for method chaining
     */
    public function setArtist(?Artist $artist): Album {
        $this->artist = $artist;
        if ($artist) {
            $this->artist_id = $artist->getId();
        }
        return $this;
    }
    
    /**
     * Get album genres
     * 
     * @return array Array of Genre objects
     */
    public function getGenres(): array {
        return $this->genres;
    }
    
    /**
     * Set album genres
     * 
     * @param array $genres Array of Genre objects
     * @return Album This Album instance for method chaining
     */
    public function setGenres(array $genres): Album {
        $this->genres = $genres;
        return $this;
    }
    
    /**
     * Add a genre to this album
     * 
     * @param Genre $genre Genre to add
     * @return Album This Album instance for method chaining
     */
    public function addGenre(Genre $genre): Album {
        $this->genres[] = $genre;
        return $this;
    }
    
    /**
     * Convert album to array
     * 
     * @param bool $include_artist Whether to include artist in the array
     * @param bool $include_genres Whether to include genres in the array
     * @return array Album data as array
     */
    public function toArray(bool $include_artist = false, bool $include_genres = false): array {
        $data = [
            'album_id' => $this->album_id,
            'artist_id' => $this->artist_id,
            'title' => $this->title,
            'release_date' => $this->release_date,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by
        ];
        
        if ($include_artist && $this->artist) {
            $data['artist'] = $this->artist->toArray();
        }
        
        if ($include_genres) {
            $data['genres'] = array_map(function($genre) {
                return $genre->toArray();
            }, $this->genres);
        }
        
        return $data;
    }
}
