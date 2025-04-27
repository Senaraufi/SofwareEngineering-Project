<?php

namespace Tests\TestsAssignment4\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Album;

class AlbumTest extends TestCase
{
    private $album;

    protected function setUp(): void
    {
        // Create an album instance with test data
        $this->album = new Album([
            'album_id' => 1,
            'title' => 'Test Album',
            'artist_id' => 2,
            'release_date' => '2023-01-01',
            'description' => 'Test album description',
            'image_url' => 'test-album.jpg'
        ]);
    }

    /**
     * Test album creation with valid data
     */
    public function testAlbumCreation()
    {
        // Arrange
        $albumData = [
            'album_id' => 5,
            'title' => 'New Test Album',
            'artist_id' => 3,
            'release_date' => '2023-05-15',
            'description' => 'A new test album description',
            'image_url' => 'new-test-album.jpg'
        ];
        
        // Act
        $newAlbum = new Album($albumData);
        
        // Assert
        $this->assertEquals(5, $newAlbum->getId());
        $this->assertEquals('New Test Album', $newAlbum->getTitle());
        $this->assertEquals('2023-05-15', $newAlbum->getReleaseDate());
        $this->assertEquals('A new test album description', $newAlbum->getDescription());
    }

    /**
     * Test album title validation
     */
    public function testAlbumTitleValidation()
    {
        // Test with valid title
        $album = new Album([
            'album_id' => 1,
            'title' => 'Valid Album Title',
            'artist_id' => 2
        ]);
        $this->assertEquals('Valid Album Title', $album->getTitle());
        $this->assertNotEmpty($album->getTitle());
        
        // Test with empty title
        $album = new Album([
            'album_id' => 1,
            'title' => '',
            'artist_id' => 2
        ]);
        $this->assertEquals('', $album->getTitle());
        $this->assertEmpty($album->getTitle());
        
        // Test with title that's too short
        $album = new Album([
            'album_id' => 1,
            'title' => 'A',
            'artist_id' => 2
        ]);
        $this->assertEquals('A', $album->getTitle());
        $this->assertEquals(1, strlen($album->getTitle()));
        
        // Test with title that's too long
        $longTitle = str_repeat("A", 256);
        $album = new Album([
            'album_id' => 1,
            'title' => $longTitle,
            'artist_id' => 2
        ]);
        $this->assertEquals($longTitle, $album->getTitle());
        $this->assertEquals(256, strlen($album->getTitle()));
    }

    /**
     * Test album release date validation
     */
    public function testAlbumReleaseDateValidation()
    {
        // Test with valid date
        $album = new Album([
            'album_id' => 1,
            'title' => 'Test Album',
            'release_date' => '2023-01-01'
        ]);
        $this->assertEquals('2023-01-01', $album->getReleaseDate());
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $album->getReleaseDate());
        
        // Test with invalid date format
        $album = new Album([
            'album_id' => 1,
            'title' => 'Test Album',
            'release_date' => 'not-a-date'
        ]);
        $this->assertEquals('not-a-date', $album->getReleaseDate());
        $this->assertDoesNotMatchRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $album->getReleaseDate());
        
        // Test with future date (should be valid)
        $futureDate = date('Y-m-d', strtotime('+1 year'));
        $album = new Album([
            'album_id' => 1,
            'title' => 'Test Album',
            'release_date' => $futureDate
        ]);
        $this->assertEquals($futureDate, $album->getReleaseDate());
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $album->getReleaseDate());
    }

    /**
     * Test album image URL validation
     */
    public function testAlbumImageUrlValidation()
    {
        // Test with valid image URL
        $album = new Album([
            'album_id' => 1,
            'title' => 'Test Album',
            'image_url' => 'valid-image.jpg'
        ]);
        $this->assertEquals('valid-image.jpg', $album->getImageUrl());
        $this->assertMatchesRegularExpression('/\.(jpg|jpeg|png|gif)$/', $album->getImageUrl());
        
        // Test with invalid image URL (wrong extension)
        $album = new Album([
            'album_id' => 1,
            'title' => 'Test Album',
            'image_url' => 'invalid-image.xyz'
        ]);
        $this->assertEquals('invalid-image.xyz', $album->getImageUrl());
        $this->assertDoesNotMatchRegularExpression('/\.(jpg|jpeg|png|gif)$/', $album->getImageUrl());
        
        // Test with empty image URL
        $album = new Album([
            'album_id' => 1,
            'title' => 'Test Album',
            'image_url' => ''
        ]);
        $this->assertEquals('', $album->getImageUrl());
        $this->assertEmpty($album->getImageUrl());
    }

    /**
     * Test album getters and setters
     */
    public function testAlbumGettersAndSetters()
    {
        // Test initial values
        $this->assertEquals(1, $this->album->getId());
        $this->assertEquals('Test Album', $this->album->getTitle());
        $this->assertEquals(2, $this->album->getArtistId());
        
        // Test setters
        $this->album->setTitle('Updated Album Title');
        $this->album->setDescription('Updated description');
        $this->album->setImageUrl('updated-image.jpg');
        
        // Test updated values
        $this->assertEquals('Updated Album Title', $this->album->getTitle());
        $this->assertEquals('Updated description', $this->album->getDescription());
        $this->assertEquals('updated-image.jpg', $this->album->getImageUrl());
    }
}
