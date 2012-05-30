<?php

namespace Acme\RentacarBundle\Tests\Controller;

use Acme\RentacarBundle\Tests\WebTestCase;

class CarClassControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->loadFixtures();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/car/');

        $this->assertTrue($crawler->filter('h1:contains("車種一覧")')->count() > 0);
        $this->assertTrue($crawler->filter('.car-class-box')->count() == 2);
    }
}
