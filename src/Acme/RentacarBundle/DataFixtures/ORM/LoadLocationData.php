<?php

namespace Acme\RentacarBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\RentacarBundle\Entity\Location;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $location1 = new Location();
        $location1->setId(1);
        $location1->setName('神楽坂');

        $location2 = new Location();
        $location2->setId(2);
        $location2->setName('青山');

        $manager->persist($location1);
        $manager->persist($location2);
        $manager->flush();

        $this->addReference('location-1', $location1);
        $this->addReference('location-2', $location2);
    }

    public function getOrder()
    {
        return 1;
    }
}
