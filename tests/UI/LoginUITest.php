<?php

namespace Tests\UI;

use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client;

class LoginUITest extends PantherTestCase
{
    private $client;
    private $baseUrl = 'http://localhost:8000';

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createPantherClient();
    }

    public function testLoginFormInteraction()
    {
        $crawler = $this->client->request('GET', $this->baseUrl . '/login');

        // Test form visibility and initial state
        $this->assertSelectorExists('form');
        $this->assertSelectorExists('input[name="username"]');
        $this->assertSelectorExists('input[name="password"]');
        $this->assertSelectorExists('button[type="submit"]');

        // Test form interaction
        $this->client->executeScript("
            document.querySelector('input[name=\"username\"]').value = 'testuser';
            document.querySelector('input[name=\"password\"]').value = 'password123';
        ");

        // Take a screenshot before submitting
        $this->client->takeScreenshot('tests/screenshots/before_login.png');

        // Submit the form
        $this->client->submitForm('button[type="submit"]', [
            'username' => 'testuser',
            'password' => 'password123'
        ]);

        // Take a screenshot after submitting
        $this->client->takeScreenshot('tests/screenshots/after_login.png');
    }

    public function testLoginFormValidation()
    {
        $crawler = $this->client->request('GET', $this->baseUrl . '/login');

        // Test empty form submission
        $this->client->submitForm('button[type="submit"]', []);
        $this->assertSelectorExists('.bg-red-100'); // Error message should appear

        // Test invalid credentials
        $this->client->submitForm('button[type="submit"]', [
            'username' => 'wronguser',
            'password' => 'wrongpass'
        ]);
        $this->assertSelectorTextContains('.bg-red-100', 'Invalid username or password');
    }

    public function testResponsiveDesign()
    {
        $crawler = $this->client->request('GET', $this->baseUrl . '/login');

        // Test mobile viewport
        $this->client->setWindowSize(375, 667); // iPhone SE size
        $this->client->takeScreenshot('tests/screenshots/login_mobile.png');
        $this->assertSelectorExists('.max-w-md'); // Check if container is present

        // Test tablet viewport
        $this->client->setWindowSize(768, 1024); // iPad size
        $this->client->takeScreenshot('tests/screenshots/login_tablet.png');

        // Test desktop viewport
        $this->client->setWindowSize(1920, 1080); // Full HD
        $this->client->takeScreenshot('tests/screenshots/login_desktop.png');
    }

    public function testAccessibility()
    {
        $crawler = $this->client->request('GET', $this->baseUrl . '/login');

        // Test form labels
        $this->assertSelectorExists('label[for="username"]');
        $this->assertSelectorExists('label[for="password"]');

        // Test ARIA attributes
        $this->assertSelectorExists('[role="alert"]'); // For error messages
        $this->assertSelectorExists('form[aria-label="Login form"]');
    }
}
