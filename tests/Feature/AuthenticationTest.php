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
        $crawler = $this->browser->request('GET', $this->baseUrl . '/login');
        $this->assertEquals(200, $this->browser->getResponse()->getStatusCode());
        $this->assertStringContainsString('Welcome Back!', $crawler->filter('h2')->text());
    }

    public function testLoginWithValidCredentials()
    {
        $crawler = $this->browser->request('POST', $this->baseUrl . '/login', [
            'username' => 'testuser',
            'password' => 'password123'
        ]);
        
        $response = $this->browser->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/dashboard', $response->getHeader('Location')[0] ?? '');
    }

    public function testLoginWithInvalidCredentials()
    {
        $crawler = $this->browser->request('POST', $this->baseUrl . '/login', [
            'username' => 'wronguser',
            'password' => 'wrongpass'
        ]);
        
        $this->assertStringContainsString('Invalid credentials', $crawler->filter('.bg-red-100')->text());
    }

    public function testLoginFormExists()
    {
        $crawler = $this->browser->request('GET', $this->baseUrl . '/login');
        
        $this->assertCount(1, $crawler->filter('form'));
        $this->assertCount(1, $crawler->filter('input[name="username"]'));
        $this->assertCount(1, $crawler->filter('input[name="password"]'));
        $this->assertCount(1, $crawler->filter('button[type="submit"]'));
    }
}
