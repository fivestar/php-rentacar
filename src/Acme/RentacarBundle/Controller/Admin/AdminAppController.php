<?php

namespace Acme\RentacarBundle\Controller\Admin;

use Crocos\SecurityBundle\Annotation\SecureConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @SecureConfig(domain="admin", basic="admin:adminpass")
 */
abstract class AdminAppController extends Controller
{
}
