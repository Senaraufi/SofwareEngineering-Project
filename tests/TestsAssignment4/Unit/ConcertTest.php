<?php

namespace Tests\TestsAssignment4\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Concert;

class ConcertTest extends TestCase
{
    private $concert;

    protected function setUp(): void
    {
        // Create a concert instance with test data
        $this->concert = new Concert([
            'concert_id' => 1,
            'artist_id' => 2,
            'name' => 'Test Concert',
            'venue_name' => 'Test Venue',
            'venue_location' => 'Test Location',
            'concert_date' => '2023-06-15',
            'concert_time' => '19:00:00',
            'description' => 'Test concert description',
            'image_url' => 'test-concert.jpg'
        ]);
    }

    /**
     * Test concert creation with valid data
     */
    public function testCreateConcertWithValidData()
    {
        // Arrange
        $concertData = [
            'concert_id' => 5,
            'artist_id' => 3,
            'name' => 'New Test Concert',
            'venue_name' => 'New Test Venue',
            'venue_location' => 'New Test Location',
            'concert_date' => '2023-07-20',
            'concert_time' => '20:00:00',
            'description' => 'A new test concert description',
            'image_url' => 'new-test-concert.jpg'
        ];
        
        // Act
        $newConcert = new Concert($concertData);
        
        // Assert
        $this->assertEquals(5, $newConcert->getId());
        $this->assertEquals('New Test Concert', $newConcert->getName());
        $this->assertEquals('New Test Venue', $newConcert->getVenueName());
        $this->assertEquals('New Test Location', $newConcert->getVenueLocation());
    }

    /**
     * Test concert date validation
     */
    public function testConcertDateValidation()
    {
        // Test with valid date
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'concert_date' => '2023-12-31'
        ]);
        $this->assertEquals('2023-12-31', $concert->getConcertDate());
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $concert->getConcertDate());
        
        // Test with invalid date format
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'concert_date' => 'not-a-date'
        ]);
        $this->assertEquals('not-a-date', $concert->getConcertDate());
        $this->assertDoesNotMatchRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $concert->getConcertDate());
        
        // Test with future date
        $futureDate = date('Y-m-d', strtotime('+30 days'));
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'concert_date' => $futureDate
        ]);
        $this->assertEquals($futureDate, $concert->getConcertDate());
    }

    /**
     * Test concert time validation
     */
    public function testConcertTimeValidation()
    {
        // Test with valid time
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'concert_time' => '19:30:00'
        ]);
        $this->assertEquals('19:30:00', $concert->getConcertTime());
        $this->assertMatchesRegularExpression('/^\d{2}:\d{2}:\d{2}$/', $concert->getConcertTime());
        
        // Test with invalid time format
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'concert_time' => 'not-a-time'
        ]);
        $this->assertEquals('not-a-time', $concert->getConcertTime());
        $this->assertDoesNotMatchRegularExpression('/^\d{2}:\d{2}:\d{2}$/', $concert->getConcertTime());
        
        // Test with empty time
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'concert_time' => ''
        ]);
        $this->assertEmpty($concert->getConcertTime());
    }

    /**
     * Test venue name validation
     */
    public function testVenueNameValidation()
    {
        // Test with valid venue name
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'venue_name' => 'Wembley Stadium'
        ]);
        $this->assertEquals('Wembley Stadium', $concert->getVenueName());
        $this->assertNotEmpty($concert->getVenueName());
        
        // Test with empty venue name
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'venue_name' => ''
        ]);
        $this->assertEquals('', $concert->getVenueName());
        $this->assertEmpty($concert->getVenueName());
        
        // Test with very long venue name
        $longVenueName = str_repeat("A", 100);
        $concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'venue_name' => $longVenueName
        ]);
        $this->assertEquals($longVenueName, $concert->getVenueName());
        $this->assertEquals(100, strlen($concert->getVenueName()));
    }

    /**
     * Test concert getters and setters
     */
    public function testConcertGettersAndSetters()
    {
        // Test initial values
        $this->assertEquals(1, $this->concert->getId());
        $this->assertEquals('Test Concert', $this->concert->getName());
        $this->assertEquals('Test Venue', $this->concert->getVenueName());
        $this->assertEquals('Test Location', $this->concert->getVenueLocation());
        
        // Test setters
        $this->concert->setName('Updated Concert Name');
        $this->concert->setVenueName('Updated Venue');
        $this->concert->setVenueLocation('Updated Location');
        $this->concert->setDescription('Updated description');
        
        // Test updated values
        $this->assertEquals('Updated Concert Name', $this->concert->getName());
        $this->assertEquals('Updated Venue', $this->concert->getVenueName());
        $this->assertEquals('Updated Location', $this->concert->getVenueLocation());
        $this->assertEquals('Updated description', $this->concert->getDescription());
    }
}
