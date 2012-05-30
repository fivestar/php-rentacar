<?php

namespace Acme\RentacarBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class HomeController extends AdminAppController
{
    /**
     * @Route("/", name="admin_home")
     * @Template
     */
    public function indexAction(Request $request)
    {
        return array();
    }
}
