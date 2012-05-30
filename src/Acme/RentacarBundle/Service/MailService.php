<?php

namespace Acme\RentacarBundle\Service;

use Acme\RentacarBundle\Entity\Reservation;
use Acme\RentacarBundle\Entity\User;

/**
 * MailService.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class MailService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * Send reservation mail.
     *
     * @param Reservation $reservation
     * @param User $user
     */
    public function sendReservationMail(Reservation $reservation, User $user)
    {
        $body = $this->render('AcmeRentacarBundle:Mail:reservation.txt.twig', array(
            'reservation' => $reservation,
            'user'        => $user,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('予約を受け付けました')
            ->setFrom(array('noreply@example.com' => 'PHPレンタカー'))
            ->setTo($user->getEmail())
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }

    /**
     * Send registration confirm mail.
     *
     * @param User $user
     */
    public function sendRegistrationConfirmMail(User $user)
    {
        $body = $this->render('AcmeRentacarBundle:Mail:registrationConfirm.txt.twig', array(
            'user' => $user,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('仮登録が完了しました')
            ->setFrom(array('noreply@example.com' => 'PHPレンタカー'))
            ->setTo($user->getEmail())
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }

    /**
     * Send duplicated registration mail.
     *
     * @param User $user
     */
    public function sendDuplicatedRegistrationMail(User $user)
    {
        $body = $this->render('AcmeRentacarBundle:Mail:duplicatedRegistration.txt.twig', array(
            'user' => $user,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('既に登録されたメールアドレスです')
            ->setFrom(array('noreply@example.com' => 'PHPレンタカー'))
            ->setTo($user->getEmail())
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }

    /**
     * Send reservations mail for admin.
     *
     * @param \DateTime $today
     * @param Collection $reservations
     * @param string $email
     */
    public function sendReservationsTodayMailForAdmin(\DateTime $today, $reservations, $email)
    {
        $body = $this->render('AcmeRentacarBundle:Mail/Admin:reservationsToday.txt.twig', array(
            'today'        => $today,
            'reservations' => $reservations,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject(sprintf('%sの予約一覧', $today->format('Y/m/d')))
            ->setFrom(array('noreply@example.com' => 'PHPレンタカー'))
            ->setTo($email)
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }

    /**
     * Render twig template.
     *
     * @param string $template
     * @param array $variables
     * @return string
     */
    protected function render($template, array $variables = array())
    {
        return $this->twig->loadTemplate($template)->render($variables);
    }
}
