<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Artist;
use App\Models\Genre;

class ArtistTest extends TestCase
{
    private $testData;
    private $artist;
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test genre
        $this->genre = new Genre([
            'genre_id' => 1,
            'name' => 'Rock',
            'description' => 'Rock music'
        ]);

        // Setup test data
        $this->testData = [
            'artist_id' => 1,
            'name' => 'Test Artist',
            'description' => 'Test Description',
            'image_url' => 'http://example.com/image.jpg',
            'created_at' => '2025-04-04 15:21:51',
            'updated_at' => '2025-04-04 15:21:51',
            'updated_by' => 1,
            'genres' => [$this->genre]
        ];

        $this->artist = new Artist($this->testData);
    }

    public function testArtistInitialization()
    {
        $this->assertEquals($this->testData['artist_id'], $this->artist->getId());
        $this->assertEquals($this->testData['name'], $this->artist->getName());
        $this->assertEquals($this->testData['description'], $this->artist->getDescription());
        $this->assertEquals($this->testData['image_url'], $this->artist->getImageUrl());
        $this->assertEquals($this->testData['created_at'], $this->artist->getCreatedAt());
        $this->assertEquals($this->testData['updated_at'], $this->artist->getUpdatedAt());
        $this->assertEquals($this->testData['updated_by'], $this->artist->getUpdatedBy());
        $this->assertEquals($this->testData['genres'], $this->artist->getGenres());
    }

    public function testEmptyInitialization()
    {
        $emptyArtist = new Artist();
        $this->assertNull($emptyArtist->getId());
        $this->assertEquals('', $emptyArtist->getName());
        $this->assertNull($emptyArtist->getDescription());
        $this->assertNull($emptyArtist->getImageUrl());
        $this->assertNull($emptyArtist->getCreatedAt());
        $this->assertNull($emptyArtist->getUpdatedAt());
        $this->assertNull($emptyArtist->getUpdatedBy());
        $this->assertEmpty($emptyArtist->getGenres());
    }

    public function testSetterMethods()
    {
        $newName = 'New Artist Name';
        $newDescription = 'New Description';
        $newImageUrl = 'http://example.com/new-image.jpg';
        $newUserId = 2;
        $newGenres = [new Genre(['genre_id' => 2, 'name' => 'Pop'])];

        $this->artist->setName($newName)
                    ->setDescription($newDescription)
                    ->setImageUrl($newImageUrl)
                    ->setUpdatedBy($newUserId)
                    ->setGenres($newGenres);

        $this->assertEquals($newName, $this->artist->getName());
        $this->assertEquals($newDescription, $this->artist->getDescription());
        $this->assertEquals($newImageUrl, $this->artist->getImageUrl());
        $this->assertEquals($newUserId, $this->artist->getUpdatedBy());
        $this->assertEquals($newGenres, $this->artist->getGenres());
    }

    public function testAddGenre()
    {
        $newGenre = new Genre([
            'genre_id' => 2,
            'name' => 'Pop',
            'description' => 'Pop music'
        ]);

        $initialGenreCount = count($this->artist->getGenres());
        $this->artist->addGenre($newGenre);
        
        $this->assertCount($initialGenreCount + 1, $this->artist->getGenres());
        $this->assertContains($newGenre, $this->artist->getGenres());
    }

    public function testToArrayWithoutGenres()
    {
        $array = $this->artist->toArray(false);
        
        $this->assertArrayHasKey('artist_id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('description', $array);
        $this->assertArrayHasKey('image_url', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('updated_by', $array);
        $this->assertArrayNotHasKey('genres', $array);
    }

    public function testToArrayWithGenres()
    {
        $array = $this->artist->toArray(true);
        
        $this->assertArrayHasKey('genres', $array);
        $this->assertIsArray($array['genres']);
        $this->assertCount(1, $array['genres']);
        $this->assertEquals($this->genre->toArray(), $array['genres'][0]);
    }

    public function testNullableFields()
    {
        $artist = new Artist([
            'name' => 'Test Artist',
            'description' => null,
            'image_url' => null,
            'updated_by' => null
        ]);

        $this->assertNull($artist->getDescription());
        $this->assertNull($artist->getImageUrl());
        $this->assertNull($artist->getUpdatedBy());
    }
}
