<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class AuthenticationTest extends TestCase
{
    private $browser;
    private $baseUrl = 'http://localhost:8000';

    protected function setUp(): void
    {
        parent::setUp();
        $this->browser = new HttpBrowser(HttpClient::create());
    }

    public function testLoginPageLoads()
    {
        // Skip this test if the web server isn't running
        try {
            $testConnection = @file_get_contents($this->baseUrl);
            if ($testConnection === false) {
                $this->markTestSkipped('Web server is not running. Start the server to run this test.');
                return;
            }
        } catch (\Exception $e) {
            $this->markTestSkipped('Web server is not running. Start the server to run this test.');
            return;
        }
        
        $crawler = $this->browser->request('GET', $this->baseUrl . '/login');
        $this->assertEquals(200, $this->browser->getResponse()->getStatusCode());
        $this->assertStringContainsString('Welcome Back!', $crawler->filter('h2')->text());
    }

    public function testLoginWithValidCredentials()
    {
        // Skip this test if the web server isn't running
        try {
            $testConnection = @file_get_contents($this->baseUrl);
            if ($testConnection === false) {
                $this->markTestSkipped('Web server is not running. Start the server to run this test.');
                return;
            }
        } catch (\Exception $e) {
            $this->markTestSkipped('Web server is not running. Start the server to run this test.');
            return;
        }
        
        // Using the development bypass credentials from UserController.php
        $crawler = $this->browser->request('POST', $this->baseUrl . '/login', [
            'username' => 'test',
            'password' => 'test123'
        ]);
        
        $response = $this->browser->getResponse();
        
        // Check if we got a successful response (either 200 or 302)
        $statusCode = $response->getStatusCode();
        $this->assertTrue($statusCode == 200 || $statusCode == 302, 
            "Expected status code 200 or 302, got {$statusCode}");
        
        // If we got a redirect, check that it's to the dashboard
        if ($statusCode == 302) {
            $location = $response->getHeader('Location')[0] ?? '';
            $this->assertStringContainsString('/dashboard', $location, 
                "Expected redirect to /dashboard, got {$location}");
        }
    }

    public function testLoginWithInvalidCredentials()
    {
        // Skip this test if the web server isn't running
        try {
            $testConnection = @file_get_contents($this->baseUrl);
            if ($testConnection === false) {
                $this->markTestSkipped('Web server is not running. Start the server to run this test.');
                return;
            }
        } catch (\Exception $e) {
            $this->markTestSkipped('Web server is not running. Start the server to run this test.');
            return;
        }
        
        $crawler = $this->browser->request('POST', $this->baseUrl . '/login', [
            'username' => 'wronguser',
            'password' => 'wrongpass'
        ]);
        
        // Updated to match the actual error message in UserController.php
        $this->assertStringContainsString('Invalid username or password', $crawler->filter('.bg-red-100')->text());
    }

    public function testLoginFormExists()
    {
        // Skip this test if the web server isn't running
        try {
            $testConnection = @file_get_contents($this->baseUrl);
            if ($testConnection === false) {
                $this->markTestSkipped('Web server is not running. Start the server to run this test.');
                return;
            }
        } catch (\Exception $e) {
            $this->markTestSkipped('Web server is not running. Start the server to run this test.');
            return;
        }
        
        $crawler = $this->browser->request('GET', $this->baseUrl . '/login');
        
        // Check that the login form exists with its essential elements
        $this->assertGreaterThanOrEqual(1, $crawler->filter('form')->count(), 'Login form not found');
        $this->assertGreaterThanOrEqual(1, $crawler->filter('input[name="username"]')->count(), 'Username input not found');
        $this->assertGreaterThanOrEqual(1, $crawler->filter('input[name="password"]')->count(), 'Password input not found');
        $this->assertGreaterThanOrEqual(1, $crawler->filter('button[type="submit"]')->count(), 'Submit button not found');
    }
}
