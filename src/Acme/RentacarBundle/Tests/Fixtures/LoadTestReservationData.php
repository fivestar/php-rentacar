<?php

namespace Acme\RentacarBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\RentacarBundle\Entity\Reservation;

class LoadTestReservationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reservation2_1 = new Reservation();
        $reservation2_1->setUser($this->getReference('user-2'));
        $reservation2_1->setDepartureAt(new \DateTime('2012-04-01 12:00'));
        $reservation2_1->setDepartureLocation($this->getReference('location-1'));
        $reservation2_1->setReturnAt(new \DateTime('2012-04-02 17:30'));
        $reservation2_1->setReturnLocation($this->getReference('location-1'));
        $reservation2_1->setCarClass($this->getReference('car-class-1'));
        $reservation2_1->setUseInsurance(true);
        $reservation2_1->calculateAmount();

        $manager->persist($reservation2_1);
        $manager->flush();

        $this->addReference('user-2-reservation-1', $reservation2_1);
    }

    public function getOrder()
    {
        return 12;
    }
}
