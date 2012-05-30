<?php

namespace Acme\RentacarBundle\Tests\Entity;

use Acme\RentacarBundle\Entity\Reservation;
use Acme\RentacarBundle\Entity\CarClass;

class ReservationTest extends \PHPUnit_Framework_TestCase
{
    private $reservation;
    private $carClass;

    protected function setUp()
    {
        $reservation = new Reservation();

        $carClass = new CarClass();
        $carClass->setPrice3(3000);
        $carClass->setPrice6(6000);
        $carClass->setPrice12(8000);
        $carClass->setPrice24(10000);
        $carClass->setInsurancePrice(1000);

        $reservation->setCarClass($carClass);

        $this->reservation = $reservation;
        $this->carClass = $carClass;
    }

    /**
     * @dataProvider getCalculateAmountData
     */
    public function testCalculateAmount($departure, $return, $insurance, $carSubtotal, $optionSubtotal, $totalAmount)
    {
        $this->reservation->setDepartureAt(new \DateTime($departure));
        $this->reservation->setReturnAt(new \DateTime($return));

        $this->reservation->setUseInsurance($insurance);

        $this->reservation->calculateAmount();

        $this->assertEquals($carSubtotal, $this->reservation->getCarSubtotal());
        $this->assertEquals($optionSubtotal, $this->reservation->getOptionSubtotal());
        $this->assertEquals($totalAmount, $this->reservation->getTotalAmount());
    }

    public function getCalculateAmountData()
    {
        return array(
            array('2012-04-01 00:00', '2012-04-01 03:00', true, 3000, 1000, 3000 + 1000),
            array('2012-04-01 00:00', '2012-04-01 06:00', false, 6000, 0, 6000),
            array('2012-04-01 00:00', '2012-04-01 12:00', false, 8000, 0, 8000),
            array('2012-04-01 00:00', '2012-04-02 00:00', true, 10000, 1000, 10000 + 1000),
            array('2012-04-01 00:00', '2012-04-02 04:00', true, 16000, 2000, 16000 + 2000),
            array('2012-04-01 00:00', '2012-04-02 15:00', true, 20000, 2000, 20000 + 2000),
        );
    }
}
