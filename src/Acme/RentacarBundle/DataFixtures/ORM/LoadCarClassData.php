<?php

namespace Acme\RentacarBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\RentacarBundle\Entity\CarClass;

class LoadCarClassData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $carClass1 = new CarClass();
        $carClass1->setId(1);
        $carClass1->setName('A');
        $carClass1->setCarTypes('プリウス、SAIなど');
        $carClass1->setSeats(7);
        $carClass1->setImage('bundles/acmerentacar/images/car/prius.png');
        $carClass1->setPrice3(5000);
        $carClass1->setPrice6(7000);
        $carClass1->setPrice12(9000);
        $carClass1->setPrice24(11000);
        $carClass1->setInsurancePrice(1000);

        $carClass2 = new CarClass();
        $carClass2->setId(2);
        $carClass2->setName('W');
        $carClass2->setCarTypes('エスティマ、アルファードなど');
        $carClass2->setSeats(8);
        $carClass2->setImage('bundles/acmerentacar/images/car/estima.png');
        $carClass2->setPrice3(10000);
        $carClass2->setPrice6(13000);
        $carClass2->setPrice12(16500);
        $carClass2->setPrice24(20000);
        $carClass2->setInsurancePrice(1000);

        $manager->persist($carClass1);
        $manager->persist($carClass2);
        $manager->flush();

        $this->addReference('car-class-1', $carClass1);
        $this->addReference('car-class-2', $carClass2);
    }

    public function getOrder()
    {
        return 1;
    }
}
