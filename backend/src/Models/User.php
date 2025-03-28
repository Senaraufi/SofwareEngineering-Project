<?php

namespace App\Models;

/**
 * User Model
 * 
 * Represents a user in the TalkTempo application
 */
class User extends BaseModel {
    private $user_id;
    private $username;
    private $password;
    private $email;
    private $phone_number;
    private $bio;
    private $profile_image_url;

    private $is_admin;
    
    /**
     * Constructor
     * 
     * @param array $data User data from database
     */
    public function __construct(array $data = []) {
        $this->user_id = $data['user_id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->phone_number = $data['phone_number'] ?? null;
        $this->bio = $data['bio'] ?? null;
        $this->profile_image_url = $data['profile_image_url'] ?? null;
        parent::__construct($data);
        $this->is_admin = $data['is_admin'] ?? 0;
    }
    
    /**
     * Get user ID
     * 
     * @return int|null User ID
     */
    public function getId(): ?int {
        return $this->user_id;
    }
    
    /**
     * Get username
     * 
     * @return string Username
     */
    public function getUsername(): string {
        return $this->username;
    }
    
    /**
     * Set username
     * 
     * @param string $username New username
     * @return User This User instance for method chaining
     */
    public function setUsername(string $username): User {
        $this->username = $username;
        return $this;
    }
    
    /**
     * Get email
     * 
     * @return string Email
     */
    public function getEmail(): string {
        return $this->email;
    }
    
    /**
     * Set email
     * 
     * @param string $email New email
     * @return User This User instance for method chaining
     */
    public function setEmail(string $email): User {
        $this->email = $email;
        return $this;
    }
    
    /**
     * Get phone number
     * 
     * @return string|null Phone number
     */
    public function getPhoneNumber(): ?string {
        return $this->phone_number;
    }
    
    /**
     * Set phone number
     * 
     * @param string|null $phone_number New phone number
     * @return User This User instance for method chaining
     */
    public function setPhoneNumber(?string $phone_number): User {
        $this->phone_number = $phone_number;
        return $this;
    }
    
    /**
     * Get bio
     * 
     * @return string|null Bio
     */
    public function getBio(): ?string {
        return $this->bio;
    }
    
    /**
     * Set bio
     * 
     * @param string|null $bio New bio
     * @return User This User instance for method chaining
     */
    public function setBio(?string $bio): User {
        $this->bio = $bio;
        return $this;
    }
    
    /**
     * Get profile image URL
     * 
     * @return string|null Profile image URL
     */
    public function getProfileImageUrl(): ?string {
        return $this->profile_image_url;
    }
    
    /**
     * Set profile image URL
     * 
     * @param string|null $profile_image_url New profile image URL
     * @return User This User instance for method chaining
     */
    public function setProfileImageUrl(?string $profile_image_url): User {
        $this->profile_image_url = $profile_image_url;
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
     * Check if user is admin
     * 
     * @return bool True if user is admin, false otherwise
     */
    public function isAdmin(): bool {
        return (bool) $this->is_admin;
    }
    
    /**
     * Set admin status
     * 
     * @param bool $is_admin New admin status
     * @return User This User instance for method chaining
     */
    public function setAdmin(bool $is_admin): User {
        $this->is_admin = $is_admin ? 1 : 0;
        return $this;
    }
    
    /**
     * Convert user to array
     * 
     * @param bool $include_password Whether to include password in the array
     * @return array User data as array
     */
    public function toArray(bool $include_password = false): array {
        $data = [
            'user_id' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'bio' => $this->bio,
            'profile_image_url' => $this->profile_image_url,
            'created_at' => $this->created_at,
            'is_admin' => $this->is_admin
        ];
        
        if ($include_password) {
            $data['password'] = $this->password;
        }
        
        return $data;
    }
}
