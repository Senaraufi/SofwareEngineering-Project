<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;

class BaseModelTest extends TestCase
{
    private $testModel;
    private $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = [
            'id' => 1,
            'name' => 'Test Name',
            'created_at' => '2025-04-04 14:45:52',
            'updated_at' => '2025-04-04 14:45:52'
        ];
        $this->testModel = new TestModel($this->testData);
    }

    public function testModelInitialization()
    {
        $this->assertEquals($this->testData['id'], $this->testModel->getId());
        $this->assertEquals($this->testData['name'], $this->testModel->getName());
        $this->assertEquals($this->testData['created_at'], $this->testModel->getCreatedAt());
        $this->assertEquals($this->testData['updated_at'], $this->testModel->getUpdatedAt());
    }

    public function testEmptyInitialization()
    {
        $emptyModel = new TestModel();
        $this->assertNull($emptyModel->getId());
        $this->assertNull($emptyModel->getName());
        $this->assertNull($emptyModel->getCreatedAt());
        $this->assertNull($emptyModel->getUpdatedAt());
    }

    public function testToArray()
    {
        $array = $this->testModel->toArray();
        $this->assertEquals($this->testData['id'], $array['id']);
        $this->assertEquals($this->testData['name'], $array['name']);
        $this->assertEquals($this->testData['created_at'], $array['created_at']);
        $this->assertEquals($this->testData['updated_at'], $array['updated_at']);
    }
}
