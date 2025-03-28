<?php

namespace App\Models;

/**
 * Review Model
 * 
 * Represents a user review for an album or concert in the TalkTempo application
 */
class Review extends BaseModel {
    private $review_id;
    private $user_id;
    private $album_id;
    private $concert_id;
    private $rating;
    private $title;
    private $content;

    private $user;
    private $album;
    private $concert;
    
    /**
     * Constructor
     * 
     * @param array $data Review data from database
     */
    public function __construct(array $data = []) {
        $this->review_id = $data['review_id'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
        $this->album_id = $data['album_id'] ?? null;
        $this->concert_id = $data['concert_id'] ?? null;
        $this->rating = $data['rating'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->content = $data['content'] ?? null;
        parent::__construct($data);
    }
    
    /**
     * Get review ID
     * 
     * @return int|null Review ID
     */
    public function getId(): ?int {
        return $this->review_id;
    }
    
    /**
     * Get user ID
     * 
     * @return int|null User ID
     */
    public function getUserId(): ?int {
        return $this->user_id;
    }
    
    /**
     * Set user ID
     * 
     * @param int $user_id New user ID
     * @return Review This Review instance for method chaining
     */
    public function setUserId(int $user_id): Review {
        $this->user_id = $user_id;
        return $this;
    }
    
    /**
     * Get album ID
     * 
     * @return int|null Album ID
     */
    public function getAlbumId(): ?int {
        return $this->album_id;
    }
    
    /**
     * Set album ID
     * 
     * @param int|null $album_id New album ID
     * @return Review This Review instance for method chaining
     */
    public function setAlbumId(?int $album_id): Review {
        $this->album_id = $album_id;
        $this->concert_id = null; // A review can only be for an album OR a concert
        return $this;
    }
    
    /**
     * Get concert ID
     * 
     * @return int|null Concert ID
     */
    public function getConcertId(): ?int {
        return $this->concert_id;
    }
    
    /**
     * Set concert ID
     * 
     * @param int|null $concert_id New concert ID
     * @return Review This Review instance for method chaining
     */
    public function setConcertId(?int $concert_id): Review {
        $this->concert_id = $concert_id;
        $this->album_id = null; // A review can only be for an album OR a concert
        return $this;
    }
    
    /**
     * Get rating
     * 
     * @return float|null Rating (0-5)
     */
    public function getRating(): ?float {
        return $this->rating;
    }
    
    /**
     * Set rating
     * 
     * @param float $rating New rating (0-5)
     * @return Review This Review instance for method chaining
     * @throws \InvalidArgumentException If rating is not between 0 and 5
     */
    public function setRating(float $rating): Review {
        if ($rating < 0 || $rating > 5) {
            throw new \InvalidArgumentException('Rating must be between 0 and 5');
        }
        $this->rating = $rating;
        return $this;
    }
    
    /**
     * Get review title
     * 
     * @return string|null Review title
     */
    public function getTitle(): ?string {
        return $this->title;
    }
    
    /**
     * Set review title
     * 
     * @param string|null $title New review title
     * @return Review This Review instance for method chaining
     */
    public function setTitle(?string $title): Review {
        $this->title = $title;
        return $this;
    }
    
    /**
     * Get review content
     * 
     * @return string|null Review content
     */
    public function getContent(): ?string {
        return $this->content;
    }
    
    /**
     * Set review content
     * 
     * @param string|null $content New review content
     * @return Review This Review instance for method chaining
     */
    public function setContent(?string $content): Review {
        $this->content = $content;
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
     * Get user object
     * 
     * @return User|null User object
     */
    public function getUser(): ?User {
        return $this->user;
    }
    
    /**
     * Set user object
     * 
     * @param User|null $user User object
     * @return Review This Review instance for method chaining
     */
    public function setUser(?User $user): Review {
        $this->user = $user;
        if ($user) {
            $this->user_id = $user->getId();
        }
        return $this;
    }
    
    /**
     * Get album object
     * 
     * @return Album|null Album object
     */
    public function getAlbum(): ?Album {
        return $this->album;
    }
    
    /**
     * Set album object
     * 
     * @param Album|null $album Album object
     * @return Review This Review instance for method chaining
     */
    public function setAlbum(?Album $album): Review {
        $this->album = $album;
        if ($album) {
            $this->album_id = $album->getId();
            $this->concert_id = null; // A review can only be for an album OR a concert
        }
        return $this;
    }
    
    /**
     * Get concert object
     * 
     * @return Concert|null Concert object
     */
    public function getConcert(): ?Concert {
        return $this->concert;
    }
    
    /**
     * Set concert object
     * 
     * @param Concert|null $concert Concert object
     * @return Review This Review instance for method chaining
     */
    public function setConcert(?Concert $concert): Review {
        $this->concert = $concert;
        if ($concert) {
            $this->concert_id = $concert->getId();
            $this->album_id = null; // A review can only be for an album OR a concert
        }
        return $this;
    }
    
    /**
     * Check if this review is for an album
     * 
     * @return bool True if this review is for an album, false otherwise
     */
    public function isAlbumReview(): bool {
        return $this->album_id !== null;
    }
    
    /**
     * Check if this review is for a concert
     * 
     * @return bool True if this review is for a concert, false otherwise
     */
    public function isConcertReview(): bool {
        return $this->concert_id !== null;
    }
    
    /**
     * Convert review to array
     * 
     * @param bool $include_user Whether to include user in the array
     * @param bool $include_album Whether to include album in the array
     * @param bool $include_concert Whether to include concert in the array
     * @return array Review data as array
     */
    public function toArray(bool $include_user = false, bool $include_album = false, bool $include_concert = false): array {
        $data = [
            'review_id' => $this->review_id,
            'user_id' => $this->user_id,
            'album_id' => $this->album_id,
            'concert_id' => $this->concert_id,
            'rating' => $this->rating,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
        
        if ($include_user && $this->user) {
            $data['user'] = $this->user->toArray();
        }
        
        if ($include_album && $this->album) {
            $data['album'] = $this->album->toArray();
        }
        
        if ($include_concert && $this->concert) {
            $data['concert'] = $this->concert->toArray();
        }
        
        return $data;
    }
}
