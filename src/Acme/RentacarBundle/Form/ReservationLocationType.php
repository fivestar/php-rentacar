<?php

namespace Acme\RentacarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * ReservationLocationType.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 */
class ReservationLocationType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('departureAt')
            ->add('departureLocation')
            ->add('returnAt')
            ->add('returnLocation')
        ;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'reservation_location';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'validation_groups' => array('reservation_location'),
        );
    }
}
