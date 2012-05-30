<?php

namespace Acme\RentacarBundle\Controller;

use Crocos\SecurityBundle\Annotation\Secure;
use Crocos\SecurityBundle\Annotation\SecureConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @SecureConfig(forward="AcmeRentacarBundle:Security:login", auth="session.entity")
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class AppController extends Controller
{
    public function getSecurity()
    {
        return $this->get('crocos_security.context');
    }

    public function getUser()
    {
        return $this->getSecurity()->getUser();
    }
}
