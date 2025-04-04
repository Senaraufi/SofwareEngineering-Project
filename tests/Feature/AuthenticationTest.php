<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class AuthenticationTest extends TestCase
{
    private $browser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->browser = new HttpBrowser(HttpClient::create());
    }

    public function testLoginPageLoads()
    {
        $crawler = $this->browser->request('GET', 'http://localhost:8000/login');
        $this->assertEquals(200, $this->browser->getResponse()->getStatusCode());
        $this->assertStringContainsString('Login', $crawler->filter('h1')->text());
    }

    public function testLoginWithValidCredentials()
    {
        $crawler = $this->browser->request('POST', 'http://localhost:8000/login', [
            'username' => 'testuser',
            'password' => 'password123'
        ]);
        
        $this->assertTrue($this->browser->getResponse()->isRedirect('/dashboard'));
    }

    public function testLoginWithInvalidCredentials()
    {
        $crawler = $this->browser->request('POST', 'http://localhost:8000/login', [
            'username' => 'wronguser',
            'password' => 'wrongpass'
        ]);
        
        $this->assertStringContainsString('Invalid credentials', $crawler->filter('.error-message')->text());
    }
}
