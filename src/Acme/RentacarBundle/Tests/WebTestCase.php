<?php

namespace Acme\RentacarBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Doctrine\Bundle\FixturesBundle\Common\DataFixtures\Loader as DataFixturesLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

abstract class WebTestCase extends BaseWebTestCase
{
    public function loadFixtures()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $loader = new DataFixturesLoader($container);
        $loader->loadFromDirectory(__DIR__.'/Fixtures');
        $fixtures = $loader->getFixtures();

        $manager = $container->get('doctrine')->getEntityManager();

        $purger = new ORMPurger($manager);
        $executor = new ORMExecutor($manager, $purger);

        $executor->execute($fixtures);
    }

    public function login($client, $email, $password = 'password')
    {
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('ログイン')->form();
        $crawler = $client->submit($form, array(
            'login[email]'    => $email,
            'login[password]' => $password,
        ));

        return $crawler;
    }
}
