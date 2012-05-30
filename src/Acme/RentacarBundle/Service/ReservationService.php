<?php

namespace Acme\RentacarBundle\Service;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Acme\RentacarBundle\Entity\User;
use Acme\RentacarBundle\Entity\Reservation;

/**
 * ReservationService.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class ReservationService
{
    /**
     * @var RegistryInterface
     */
    private $managerRegistry;

    /**
     * @var MailService
     */
    private $mailService;

    /**
     * Constructor.
     *
     * @param RegistryInterface $managerRegistry
     * @MailService $mailService
     */
    public function __construct(RegistryInterface $managerRegistry, MailService $mailService)
    {
        $this->managerRegistry = $managerRegistry;
        $this->mailService = $mailService;
    }

    /**
     * Save reservation.
     *
     * @param Reservation $reservation
     * @param User $user
     */
    public function saveReservation(Reservation $reservation, User $user)
    {
        $manager = $this->managerRegistry->getEntityManager();

        $reservation->setUser($user);

        $manager->persist($reservation);
        $manager->flush();

        $this->mailService->sendReservationMail($reservation, $user);
    }
}
