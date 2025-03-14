<?php

namespace App\Models;

/**
 * Concert Model
 * 
 * Represents a concert in the TalkTempo application
 */
class Concert {
    private $concert_id;
    private $artist_id;
    private $name;
    private $venue_name;
    private $venue_location;
    private $concert_date;
    private $concert_time;
    private $description;
    private $image_url;
    private $created_at;
    private $updated_at;
    private $updated_by;
    private $artist;
    
    /**
     * Constructor
     * 
     * @param array $data Concert data from database
     */
    public function __construct(array $data = []) {
        $this->concert_id = $data['concert_id'] ?? null;
        $this->artist_id = $data['artist_id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->venue_name = $data['venue_name'] ?? '';
        $this->venue_location = $data['venue_location'] ?? null;
        $this->concert_date = $data['concert_date'] ?? null;
        $this->concert_time = $data['concert_time'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->image_url = $data['image_url'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->updated_by = $data['updated_by'] ?? null;
    }
    
    /**
     * Get concert ID
     * 
     * @return int|null Concert ID
     */
    public function getId(): ?int {
        return $this->concert_id;
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
     * @return Concert This Concert instance for method chaining
     */
    public function setArtistId(int $artist_id): Concert {
        $this->artist_id = $artist_id;
        return $this;
    }
    
    /**
     * Get concert name
     * 
     * @return string Concert name
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Set concert name
     * 
     * @param string $name New concert name
     * @return Concert This Concert instance for method chaining
     */
    public function setName(string $name): Concert {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get venue name
     * 
     * @return string Venue name
     */
    public function getVenueName(): string {
        return $this->venue_name;
    }
    
    /**
     * Set venue name
     * 
     * @param string $venue_name New venue name
     * @return Concert This Concert instance for method chaining
     */
    public function setVenueName(string $venue_name): Concert {
        $this->venue_name = $venue_name;
        return $this;
    }
    
    /**
     * Get venue location
     * 
     * @return string|null Venue location
     */
    public function getVenueLocation(): ?string {
        return $this->venue_location;
    }
    
    /**
     * Set venue location
     * 
     * @param string|null $venue_location New venue location
     * @return Concert This Concert instance for method chaining
     */
    public function setVenueLocation(?string $venue_location): Concert {
        $this->venue_location = $venue_location;
        return $this;
    }
    
    /**
     * Get concert date
     * 
     * @return string|null Concert date
     */
    public function getConcertDate(): ?string {
        return $this->concert_date;
    }
    
    /**
     * Set concert date
     * 
     * @param string|null $concert_date New concert date (Y-m-d format)
     * @return Concert This Concert instance for method chaining
     */
    public function setConcertDate(?string $concert_date): Concert {
        $this->concert_date = $concert_date;
        return $this;
    }
    
    /**
     * Get concert time
     * 
     * @return string|null Concert time
     */
    public function getConcertTime(): ?string {
        return $this->concert_time;
    }
    
    /**
     * Set concert time
     * 
     * @param string|null $concert_time New concert time (H:i:s format)
     * @return Concert This Concert instance for method chaining
     */
    public function setConcertTime(?string $concert_time): Concert {
        $this->concert_time = $concert_time;
        return $this;
    }
    
    /**
     * Get concert description
     * 
     * @return string|null Concert description
     */
    public function getDescription(): ?string {
        return $this->description;
    }
    
    /**
     * Set concert description
     * 
     * @param string|null $description New concert description
     * @return Concert This Concert instance for method chaining
     */
    public function setDescription(?string $description): Concert {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Get concert image URL
     * 
     * @return string|null Concert image URL
     */
    public function getImageUrl(): ?string {
        return $this->image_url;
    }
    
    /**
     * Set concert image URL
     * 
     * @param string|null $image_url New concert image URL
     * @return Concert This Concert instance for method chaining
     */
    public function setImageUrl(?string $image_url): Concert {
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
     * @param int|null $user_id User ID who updated this concert
     * @return Concert This Concert instance for method chaining
     */
    public function setUpdatedBy(?int $user_id): Concert {
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
     * @return Concert This Concert instance for method chaining
     */
    public function setArtist(?Artist $artist): Concert {
        $this->artist = $artist;
        if ($artist) {
            $this->artist_id = $artist->getId();
        }
        return $this;
    }
    
    /**
     * Convert concert to array
     * 
     * @param bool $include_artist Whether to include artist in the array
     * @return array Concert data as array
     */
    public function toArray(bool $include_artist = false): array {
        $data = [
            'concert_id' => $this->concert_id,
            'artist_id' => $this->artist_id,
            'name' => $this->name,
            'venue_name' => $this->venue_name,
            'venue_location' => $this->venue_location,
            'concert_date' => $this->concert_date,
            'concert_time' => $this->concert_time,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by
        ];
        
        if ($include_artist && $this->artist) {
            $data['artist'] = $this->artist->toArray();
        }
        
        return $data;
    }
}
