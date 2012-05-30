<?php

namespace Acme\RentacarBundle\Tests\Entity;

use Acme\RentacarBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testSetRawPassword()
    {
        $user = new User();

        $user->setRawPassword('password');

        $this->assertTrue(null !== $user->getPassword());
        $this->assertTrue($user->isValidPassword('password'));
    }

    public function testIsEnabled()
    {
        $user = new User();

        $user->setActivationKey(null);

        $this->assertTrue($user->isEnabled());
    }

    public function testIsNotEnaledIfUserHasActivationKey()
    {
        $user = new User();

        $user->setActivationKey('foo');

        $this->assertFalse($user->isEnabled());
    }
}
