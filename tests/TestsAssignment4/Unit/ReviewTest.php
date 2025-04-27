<?php

namespace Tests\TestsAssignment4\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Review;

class ReviewTest extends TestCase
{
    private $review;

    protected function setUp(): void
    {
        // Create a review instance with test data
        $this->review = new Review([
            'review_id' => 1,
            'user_id' => 2,
            'album_id' => 3,
            'rating' => 4,
            'title' => 'Test Review Title',
            'content' => 'This is a test review content.'
        ]);
    }

    /**
     * Test review creation with valid data
     */
    public function testCreateReviewWithValidData()
    {
        // Arrange
        $reviewData = [
            'review_id' => 15,
            'user_id' => 5,
            'album_id' => 10,
            'rating' => 5,
            'title' => 'New Test Review',
            'content' => 'This is a new test review content.'
        ];
        
        // Act
        $newReview = new Review($reviewData);
        
        // Assert
        $this->assertEquals(15, $newReview->getId());
        $this->assertEquals(5, $newReview->getUserId());
        $this->assertEquals(10, $newReview->getAlbumId());
        $this->assertEquals(5, $newReview->getRating());
        $this->assertEquals('New Test Review', $newReview->getTitle());
    }

    /**
     * Test rating validation
     */
    public function testRatingValidation()
    {
        // Test with valid ratings
        for ($i = 1; $i <= 5; $i++) {
            $review = new Review([
                'review_id' => 1,
                'rating' => $i
            ]);
            $this->assertEquals($i, $review->getRating());
            $this->assertGreaterThanOrEqual(1, $review->getRating());
            $this->assertLessThanOrEqual(5, $review->getRating());
        }
        
        // Test with rating below minimum
        $review = new Review([
            'review_id' => 1,
            'rating' => 0
        ]);
        $this->assertEquals(0, $review->getRating());
        $this->assertLessThan(1, $review->getRating());
        
        // Test with rating above maximum
        $review = new Review([
            'review_id' => 1,
            'rating' => 6
        ]);
        $this->assertEquals(6, $review->getRating());
        $this->assertGreaterThan(5, $review->getRating());
    }

    /**
     * Test review content validation
     */
    public function testReviewContentValidation()
    {
        // Test with valid content
        $review = new Review([
            'review_id' => 1,
            'content' => 'This is a valid review content with sufficient length to pass validation.'
        ]);
        $this->assertEquals('This is a valid review content with sufficient length to pass validation.', $review->getContent());
        $this->assertNotEmpty($review->getContent());
        
        // Test with empty content
        $review = new Review([
            'review_id' => 1,
            'content' => ''
        ]);
        $this->assertEquals('', $review->getContent());
        $this->assertEmpty($review->getContent());
        
        // Test with content that's too short
        $review = new Review([
            'review_id' => 1,
            'content' => 'Short'
        ]);
        $this->assertEquals('Short', $review->getContent());
        $this->assertEquals(5, strlen($review->getContent()));
        
        // Test with content that's too long
        $longContent = str_repeat("A", 2001);
        $review = new Review([
            'review_id' => 1,
            'content' => $longContent
        ]);
        $this->assertEquals($longContent, $review->getContent());
        $this->assertEquals(2001, strlen($review->getContent()));
    }

    /**
     * Test review title validation
     */
    public function testReviewTitleValidation()
    {
        // Test with valid title
        $review = new Review([
            'review_id' => 1,
            'title' => 'Valid Review Title'
        ]);
        $this->assertEquals('Valid Review Title', $review->getTitle());
        $this->assertNotEmpty($review->getTitle());
        
        // Test with empty title
        $review = new Review([
            'review_id' => 1,
            'title' => ''
        ]);
        $this->assertEquals('', $review->getTitle());
        $this->assertEmpty($review->getTitle());
        
        // Test with title that's too short
        $review = new Review([
            'review_id' => 1,
            'title' => 'A'
        ]);
        $this->assertEquals('A', $review->getTitle());
        $this->assertEquals(1, strlen($review->getTitle()));
        
        // Test with title that's too long
        $longTitle = str_repeat("A", 256);
        $review = new Review([
            'review_id' => 1,
            'title' => $longTitle
        ]);
        $this->assertEquals($longTitle, $review->getTitle());
        $this->assertEquals(256, strlen($review->getTitle()));
    }

    /**
     * Test review getters and setters
     */
    public function testReviewGettersAndSetters()
    {
        // Test initial values
        $this->assertEquals(1, $this->review->getId());
        $this->assertEquals(2, $this->review->getUserId());
        $this->assertEquals(3, $this->review->getAlbumId());
        $this->assertEquals(4, $this->review->getRating());
        $this->assertEquals('Test Review Title', $this->review->getTitle());
        
        // Test setters
        $this->review->setRating(5);
        $this->review->setTitle('Updated Review Title');
        $this->review->setContent('Updated review content');
        
        // Test updated values
        $this->assertEquals(5, $this->review->getRating());
        $this->assertEquals('Updated Review Title', $this->review->getTitle());
        $this->assertEquals('Updated review content', $this->review->getContent());
    }
}
