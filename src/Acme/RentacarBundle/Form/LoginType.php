<?php

namespace Acme\RentacarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;

/**
 * LoginType.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class LoginType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('password', 'password')
        ;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'login';
    }
}
