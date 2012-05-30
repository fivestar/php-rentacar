<?php

namespace Acme\RentacarBundle\Tests\Controller;

use Acme\RentacarBundle\Tests\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->loadFixtures();
    }

    public function testLogin()
    {
        $client = static::createClient();

        // login
        $this->login($client, 'user1@example.com');

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('.nav a:contains("ログイン")')->count() === 0);
        $this->assertTrue($crawler->filter('.nav a:contains("ログアウト")')->count() > 0);
    }

    public function testLoginError()
    {
        $client = static::createClient();

        $crawler = $this->login($client, '', '');

        $this->assertTrue($crawler->filter('.alert:contains("メールアドレスとパスワードを入力してください")')->count() > 0);

        $crawler = $this->login($client, 'unknown@example.com', 'password');

        $this->assertTrue($crawler->filter('.alert:contains("メールアドレスかパスワードが間違っています")')->count() > 0);

        $crawler = $this->login($client, 'user1@example.com', 'invalid_password');

        $this->assertTrue($crawler->filter('.alert:contains("メールアドレスかパスワードが間違っています")')->count() > 0);
    }

    public function testLoginRedirectToHomepageIfAlreadyLoggedIn()
    {
        $client = static::createClient();

        $this->login($client, 'user1@example.com');

        $crawler = $client->request('GET', '/login');

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("ホーム")')->count() > 0);
    }

    public function testLogout()
    {
        $client = static::createClient();

        $this->login($client, 'user1@example.com');

        $crawler = $client->request('GET', '/logout');

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('.nav a:contains("ログイン")')->count() > 0);
        $this->assertTrue($crawler->filter('.nav a:contains("ログアウト")')->count() === 0);
    }
}
