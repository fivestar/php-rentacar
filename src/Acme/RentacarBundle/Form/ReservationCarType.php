<?php

namespace Acme\RentacarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * ReservationCarType.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class ReservationCarType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('carClass')
        ;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'reservation_car';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'validation_groups' => array('reservation_car'),
        );
    }
}
