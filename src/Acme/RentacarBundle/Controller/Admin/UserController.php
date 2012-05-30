<?php

namespace Acme\RentacarBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/user")
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class UserController extends AdminAppController
{
    /**
     * @Route("/", name="admin_user")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $userRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:User');
        $query = $userRepository->createQueryBuilder('r')->orderBy('r.id', 'DESC')->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->get('p', 1), 30);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Route("/{id}", name="admin_user_show", requirements={"id" = "\d+"})
     * @Template
     */
    public function showAction(Request $request, $id)
    {
        $userRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:User');
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException();
        }

        return array(
            'user' => $user,
        );
    }
}
