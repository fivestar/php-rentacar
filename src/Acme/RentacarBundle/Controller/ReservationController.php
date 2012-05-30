<?php

namespace Acme\RentacarBundle\Controller;

use Crocos\SecurityBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Acme\RentacarBundle\Entity\Reservation;
use Acme\RentacarBundle\Form\ReservationLocationType;
use Acme\RentacarBundle\Form\ReservationCarType;
use Acme\RentacarBundle\Form\ReservationOptionType;

/**
 * ReservationController.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 *
 * @Route("/reservation")
 */
class ReservationController extends AppController
{
    /**
     * @Route("/", name="reservation")
     * @Template
     */
    public function indexAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/new", name="reservation_new")
     * @Template
     */
    public function newAction(Request $request)
    {
        $reservation = new Reservation();

        $form = $this->createForm(new ReservationLocationType(), $reservation);

        if ('POST' === $request->getMethod()) {
            $data = $request->request->get($form->getName());
            $form->bind($data);
            if ($form->isValid()) {
                $request->getSession()->set('reservation/location', $data);

                return $this->redirect($this->generateUrl('reservation_car'));
            }
        } elseif ($request->getSession()->has('reservation/location')) {
            $data = $request->getSession()->get('reservation/location');
            $data['_token'] = $form['_token']->getData();
            $form->bind($data);
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/car", name="reservation_car")
     * @Template
     */
    public function carAction(Request $request)
    {
        $reservation = new Reservation();

        if (!$this->restoreReservationForms($reservation, array('location'))) {
            return $this->redirect($this->generateUrl('reservation_new'));
        }

        $carClassRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:CarClass');
        $carClasses = $carClassRepository->findAll();

        $form = $this->createForm(new ReservationCarType(), $reservation);
        if ('POST' === $request->getMethod()) {
            $data = $request->request->get($form->getName());
            $form->bind($data);
            if ($form->isValid()) {
                $request->getSession()->set('reservation/car', $data);

                return $this->redirect($this->generateUrl('reservation_option'));
            }
        }

        return array(
            'carClasses' => $carClasses,
            'form'       => $form->createView(),
        );
    }

    /**
     * @Route("/option", name="reservation_option")
     * @Template
     * @Secure
     */
    public function optionAction(Request $request)
    {
        $reservation = new Reservation();

        if (!$this->restoreReservationForms($reservation, array('location', 'car'))) {
            return $this->redirect($this->generateUrl('reservation_new'));
        }

        $form = $this->createForm(new ReservationOptionType(), $reservation);

        if ('POST' === $request->getMethod()) {
            $data = $request->request->get($form->getName());
            $form->bind($data);
            if ($form->isValid()) {
                $request->getSession()->set('reservation/option', $data);

                return $this->redirect($this->generateUrl('reservation_confirm'));
            }
        } elseif ($request->getSession()->has('reservation/option')) {
            $data = $request->getSession()->get('reservation/option');
            $data['_token'] = $form['_token']->getData();
            $form->bind($data);
        }

        return array(
            'reservation' => $reservation,
            'form'        => $form->createView(),
        );
    }

    /**
     * @Route("/confirm", name="reservation_confirm")
     * @Template
     * @Secure
     */
    public function confirmAction(Request $request)
    {
        $reservation = new Reservation();

        if (!$this->restoreReservationForms($reservation, array('location', 'car', 'option'))) {
            return $this->redirect($this->generateUrl('reservation_new'));
        }

        $reservation->calculateAmount();

        if ('POST' === $request->getMethod()) {
            $user = $this->get('doctrine')->getRepository('AcmeRentacarBundle:User')->find(1);

            $service = $this->get('rentacar.reservation_service');
            $service->saveReservation($reservation, $this->getUser());

            $session = $request->getSession();
            $session->remove('reservation/location');
            $session->remove('reservation/car');
            $session->remove('reservation/option');

            return $this->redirect($this->generateUrl('reservation_finish'));
        }

        return array(
            'reservation' => $reservation,
        );
    }

    /**
     * @Route("/finish", name="reservation_finish")
     * @Template
     * @Secure
     */
    public function finishAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/history", name="reservation_history")
     * @Template
     * @Secure
     */
    public function historyAction(Request $request)
    {
        $reservationRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:Reservation');
        $reservations = $reservationRepository->findBy(array(
            'user' => $this->getUser()->getId(),
        ), array('id' => 'DESC'));

        return array(
            'reservations' => $reservations,
        );
    }

    /**
     * Restore reservation data.
     *
     * @param Reservation $reservation
     * @param $formKeys
     * @return boolean
     */
    private function restoreReservationForms(Reservation $reservation, array $formKeys)
    {
        $session = $this->getRequest()->getSession();

        $factory = $this->get('form.factory');
        $binder = function($type, $data) use($factory, $reservation) {
            if (isset($data['_token'])) {
                unset($data['_token']);
            }
            $form = $factory->create($type, $reservation, array('csrf_protection' => false));
            $form->bind($data);

            return $form->isValid();
        };

        $valid = true;
        foreach ($formKeys as $formKey) {
            switch ($formKey) {
                case 'location':
                    $valid = $binder(new ReservationLocationType(), $session->get('reservation/location'));
                    break;
                case 'car':
                    $valid = $binder(new ReservationCarType(), $session->get('reservation/car'));
                    break;
                case 'option':
                    $valid = $binder(new ReservationOptionType(), $session->get('reservation/option'));
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Unknown form key "%s"', $formKey));
            }

            if (!$valid) {
                return false;
            }
        }

        return true;
    }
}
