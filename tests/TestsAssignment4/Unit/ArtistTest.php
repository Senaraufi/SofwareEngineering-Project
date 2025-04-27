<?php

namespace Tests\TestsAssignment4\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Artist;

class ArtistTest extends TestCase
{
    private $artist;

    protected function setUp(): void
    {
        // Create an artist instance with test data
        $this->artist = new Artist([
            'artist_id' => 1,
            'name' => 'Test Artist',
            'description' => 'This is a test artist description',
            'image_url' => 'test-artist.jpg'
        ]);
    }

    /**
     * Test artist creation with valid data
     */
    public function testCreateArtistWithValidData()
    {
        // Arrange
        $artistData = [
            'artist_id' => 5,
            'name' => 'New Test Artist',
            'description' => 'This is a new test artist description',
            'image_url' => 'new-test-artist.jpg'
        ];
        
        // Act
        $newArtist = new Artist($artistData);
        
        // Assert
        $this->assertEquals(5, $newArtist->getId());
        $this->assertEquals('New Test Artist', $newArtist->getName());
        $this->assertEquals('This is a new test artist description', $newArtist->getDescription());
    }

    /**
     * Test artist name validation
     */
    public function testArtistNameValidation()
    {
        // Test with valid name
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'Valid Artist Name'
        ]);
        $this->assertEquals('Valid Artist Name', $artist->getName());
        $this->assertNotEmpty($artist->getName());
        
        // Test with empty name
        $artist = new Artist([
            'artist_id' => 1,
            'name' => ''
        ]);
        $this->assertEquals('', $artist->getName());
        $this->assertEmpty($artist->getName());
        
        // Test with name that's too short
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'A'
        ]);
        $this->assertEquals('A', $artist->getName());
        $this->assertEquals(1, strlen($artist->getName()));
        
        // Test with name that's too long
        $longName = str_repeat("A", 256);
        $artist = new Artist([
            'artist_id' => 1,
            'name' => $longName
        ]);
        $this->assertEquals($longName, $artist->getName());
        $this->assertEquals(256, strlen($artist->getName()));
    }

    /**
     * Test description validation
     */
    public function testDescriptionValidation()
    {
        // Test with valid description
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'Test Artist',
            'description' => 'This is a valid artist description'
        ]);
        $this->assertEquals('This is a valid artist description', $artist->getDescription());
        $this->assertNotEmpty($artist->getDescription());
        
        // Test with empty description
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'Test Artist',
            'description' => ''
        ]);
        $this->assertEmpty($artist->getDescription());
        
        // Test with very long description
        $longDesc = str_repeat("A", 1000);
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'Test Artist',
            'description' => $longDesc
        ]);
        $this->assertEquals($longDesc, $artist->getDescription());
        $this->assertEquals(1000, strlen($artist->getDescription()));
    }

    /**
     * Test image URL validation
     */
    public function testImageUrlValidation()
    {
        // Test with valid image URL
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'Test Artist',
            'image_url' => 'valid-image.jpg'
        ]);
        $this->assertEquals('valid-image.jpg', $artist->getImageUrl());
        $this->assertMatchesRegularExpression('/\.(jpg|jpeg|png|gif)$/', $artist->getImageUrl());
        
        // Test with invalid image URL (wrong extension)
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'Test Artist',
            'image_url' => 'invalid-image.xyz'
        ]);
        $this->assertEquals('invalid-image.xyz', $artist->getImageUrl());
        $this->assertDoesNotMatchRegularExpression('/\.(jpg|jpeg|png|gif)$/', $artist->getImageUrl());
        
        // Test with empty image URL
        $artist = new Artist([
            'artist_id' => 1,
            'name' => 'Test Artist',
            'image_url' => ''
        ]);
        $this->assertEquals('', $artist->getImageUrl());
        $this->assertEmpty($artist->getImageUrl());
    }

    /**
     * Test artist getters and setters
     */
    public function testArtistGettersAndSetters()
    {
        // Test initial values
        $this->assertEquals(1, $this->artist->getId());
        $this->assertEquals('Test Artist', $this->artist->getName());
        $this->assertEquals('This is a test artist description', $this->artist->getDescription());
        
        // Test setters
        $this->artist->setName('Updated Artist Name');
        $this->artist->setDescription('Updated description');
        $this->artist->setImageUrl('updated-image.jpg');
        
        // Test updated values
        $this->assertEquals('Updated Artist Name', $this->artist->getName());
        $this->assertEquals('Updated description', $this->artist->getDescription());
        $this->assertEquals('updated-image.jpg', $this->artist->getImageUrl());
    }
}
