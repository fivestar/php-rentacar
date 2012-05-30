<?php

namespace Acme\RentacarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * ReservationOptionType.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class ReservationOptionType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('useInsurance', 'checkbox', array(
                'required' => false,
            ))
            ->add('note')
        ;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'reservation_option';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'validation_groups' => array('reservation_option'),
        );
    }
}
