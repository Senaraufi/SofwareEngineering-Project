<?php

namespace Tests\TestsAssignment4\EquivalencePartition;

use PHPUnit\Framework\TestCase;
use App\Models\Concert;

/**
 * Equivalence Partition Testing for Concert Ticket Booking
 * 
 * This test class implements equivalence partition testing for the ticket booking functionality
 * of the Concert class. We divide the input domain (number of tickets) into equivalence classes
 * and test representative values from each class.
 */
class EquivalencePartitionTest extends TestCase
{
    private $concert;

    protected function setUp(): void
    {
        // Create a concert instance with test data
        $this->concert = new Concert([
            'concert_id' => 1,
            'name' => 'Test Concert',
            'venue_name' => 'Test Venue',
            'concert_date' => '2025-05-15',
            'available_tickets' => 100,
            'ticket_price' => 49.99
        ]);
    }

    /**
     * Test booking negative number of tickets
     * Equivalence class: negative tickets (invalid)
     */
    public function testBookingNegativeTickets()
    {
        // Arrange
        $initialTickets = 100;
        $ticketsToBook = -5;
        
        // Act
        $result = $this->concert->bookTickets($ticketsToBook);
        
        // Assert
        $this->assertLessThan(0, $ticketsToBook);
        $this->assertEquals(1, $this->concert->getId());
        $this->assertEquals('Test Concert', $this->concert->getName());
        $this->assertFalse($result);
        $this->assertEquals(100, $this->concert->getAvailableTickets());
    }

    /**
     * Test booking a small number of tickets
     * Equivalence class: small positive number (1-10) (valid)
     */
    public function testBookingSmallNumberOfTickets()
    {
        // Arrange
        $ticketsToBook = 5;
        
        // Act
        $result = $this->concert->bookTickets($ticketsToBook);
        
        // Assert
        $this->assertGreaterThan(0, $ticketsToBook);
        $this->assertLessThanOrEqual(10, $ticketsToBook);
        $this->assertEquals(1, $this->concert->getId());
        $this->assertTrue($result);
        $this->assertEquals(95, $this->concert->getAvailableTickets());
    }

    /**
     * Test booking a medium number of tickets
     * Equivalence class: medium positive number (11-50) (valid)
     */
    public function testBookingMediumNumberOfTickets()
    {
        // Arrange
        $ticketsToBook = 25;
        
        // Act
        $result = $this->concert->bookTickets($ticketsToBook);
        
        // Assert
        $this->assertGreaterThan(10, $ticketsToBook);
        $this->assertLessThanOrEqual(50, $ticketsToBook);
        $this->assertEquals('Test Concert', $this->concert->getName());
        $this->assertTrue($result);
        $this->assertEquals(75, $this->concert->getAvailableTickets());
    }

    /**
     * Test booking a large number of tickets
     * Equivalence class: large positive number (51-99) (valid)
     */
    public function testBookingLargeNumberOfTickets()
    {
        // Arrange
        $ticketsToBook = 75;
        
        // Act
        $result = $this->concert->bookTickets($ticketsToBook);
        
        // Assert
        $this->assertGreaterThan(50, $ticketsToBook);
        $this->assertLessThan(100, $ticketsToBook);
        $this->assertEquals('Test Venue', $this->concert->getVenueName());
        $this->assertTrue($result);
        $this->assertEquals(25, $this->concert->getAvailableTickets());
    }

    /**
     * Test booking exactly all available tickets
     * Equivalence class: boundary value (exactly available tickets) (valid)
     */
    public function testBookingExactlyAllAvailableTickets()
    {
        // Arrange
        $initialTickets = 100;
        $ticketsToBook = 100;
        
        // Act
        $result = $this->concert->bookTickets($ticketsToBook);
        
        // Assert
        $this->assertEquals($initialTickets, $ticketsToBook);
        $this->assertEquals('2025-05-15', $this->concert->getConcertDate());
        $this->assertTrue($result);
        $this->assertEquals(0, $this->concert->getAvailableTickets());
    }

    /**
     * Test booking more than available tickets
     * Equivalence class: more than available tickets (invalid)
     */
    public function testBookingMoreThanAvailableTickets()
    {
        // Arrange
        $initialTickets = 100;
        $ticketsToBook = 101;
        
        // Act
        $result = $this->concert->bookTickets($ticketsToBook);
        
        // Assert
        $this->assertGreaterThan($initialTickets, $ticketsToBook);
        $this->assertEquals(1, $this->concert->getId());
        $this->assertFalse($result);
        $this->assertEquals(100, $this->concert->getAvailableTickets());
    }

    /**
     * Test booking an extremely large number of tickets
     * Equivalence class: extremely large number (invalid)
     */
    public function testBookingExtremelyLargeNumberOfTickets()
    {
        // Arrange
        $initialTickets = 100;
        $ticketsToBook = 10000;
        
        // Act
        $result = $this->concert->bookTickets($ticketsToBook);
        
        // Assert
        $this->assertGreaterThan($initialTickets, $ticketsToBook);
        $this->assertGreaterThan(1000, $ticketsToBook);
        $this->assertEquals('Test Concert', $this->concert->getName());
        $this->assertFalse($result);
        $this->assertEquals(100, $this->concert->getAvailableTickets());
    }
}
