<?php

namespace Acme\RentacarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Request;

/**
 * CarClassController.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 *
 * @Route("/car")
 */
class CarClassController extends AppController
{
    /**
     * @Route("/", name="car_class")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $carClassRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:CarClass');
        $carClasses = $carClassRepository->findAll();

        return array(
            'carClasses' => $carClasses,
        );
    }
}
