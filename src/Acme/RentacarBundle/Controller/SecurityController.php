<?php

namespace Acme\RentacarBundle\Controller;

use Crocos\SecurityBundle\Annotation\Secure;
use Crocos\SecurityBundle\Annotation\SecureConfig;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Acme\RentacarBundle\Form\LoginProxy;
use Acme\RentacarBundle\Form\LoginType;

class SecurityController extends AppController
{
    /**
     * @Route("/login", name="login")
     * @Template
     */
    public function loginAction(Request $request)
    {
        $security = $this->getSecurity();
        if ($security->isAuthenticated()) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $userRepository = $this->get('doctrine')->getRepository('AcmeRentacarBundle:User');
        $login = new LoginProxy($userRepository);

        $form = $this->createForm(new LoginType(), $login);
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $security->login($login->getUser());

                if ($security->hasPreviousUrl()) {
                    $url = $security->getPreviousUrl();
                } else {
                    $url = $this->generateUrl('homepage');
                }

                return $this->redirect($url);
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/logout", name="logout")
     * @Secure
     */
    public function logoutAction(Request $request)
    {
        $this->getSecurity()->logout();

        return $this->redirect($this->generateUrl('homepage'));
    }
}
