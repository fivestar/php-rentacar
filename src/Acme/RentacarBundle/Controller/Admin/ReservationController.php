<?php

namespace Acme\RentacarBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/reservation")
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class ReservationController extends AdminAppController
{
    /**
     * @Route("/", name="admin_reservation")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $reservationRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:Reservation');
        $query = $reservationRepository->createQueryBuilder('r')->orderBy('r.id', 'DESC')->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->get('p', 1), 30);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Route("/{id}", name="admin_reservation_show", requirements={"id" = "\d+"})
     * @Template
     */
    public function showAction(Request $request, $id)
    {
        $reservationRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:Reservation');
        $reservation = $reservationRepository->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException();
        }

        return array(
            'reservation' => $reservation,
        );
    }
}
