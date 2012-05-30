<?php

namespace Acme\RentacarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;
use Acme\RentacarBundle\Entity\Location;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', 'repeated', array(
                'type'            => 'email',
                'invalid_message' => '同じ値を入力してください',
            ))
            ->add('rawPassword', 'password', array(
                'always_empty' => false,
            ))
            ->add('tel')
            ->add('birthday', 'birthday')
            ->add('agreement', 'checkbox', array(
                'property_path' => false,
                'required'      => true,
            ))
        ;

        $builder->addValidator(new CallbackValidator(function($form) {
            if (!$form['agreement']->getData()) {
                $form['agreement']->addError(new FormError('利用規約に同意してください'));
            }
        }));
    }

    public function getName()
    {
        return 'user_registration';
    }
}
